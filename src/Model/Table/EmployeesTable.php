<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Employees Model
 *
 * @method \App\Model\Entity\Employee newEmptyEntity()
 * @method \App\Model\Entity\Employee newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Employee> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Employee get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Employee findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Employee patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Employee> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Employee|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Employee saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Employee>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Employee>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Employee>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Employee> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Employee>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Employee>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Employee>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Employee> deleteManyOrFail(iterable $entities, array $options = [])
 */
class EmployeesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('employees');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('States', [
            'foreignKey' => 'state_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Districts', [
            'foreignKey' => 'district_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('name')
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->notEmptyString('name', 'Name is required.');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email', 'Email is required.');

        $validator
            ->scalar('mobile')
            ->maxLength('mobile', 10)
            ->requirePresence('mobile', 'create')
            ->notEmptyString('mobile', 'Mobile is required.');

        $validator
            ->scalar('gender')
            ->requirePresence('gender', 'create')
            ->notEmptyString('gender', 'Gender is required.');

        $validator
            ->date('dob')
            ->requirePresence('dob', 'create')
            ->notEmptyDate('dob', 'DOB is required.');

        $validator
            // ->scalar('photo')
            ->requirePresence('photo', 'create')
            ->notEmptyFile('photo', 'create')
            ->allowEmptyFile('photo', 'update')
            /* ->uploadedFile('photo', [
                'types' => ['image/jpeg', 'image/png'],
                'maxSize' => 2 * 1024 * 1024, // 2MB
            ], 'Invalid image or file too large') */
            ->add('photo', 'customUploadValidation', [
                'rule' => function ($value, $context) {
                    $file = $context['data']['photo'] ?? null;

                    if ($file instanceof \Laminas\Diactoros\UploadedFile && $file->getError() === UPLOAD_ERR_OK) {
                        $ext = strtolower(pathinfo($file->getClientFilename(), PATHINFO_EXTENSION));
                        $validTypes = ['image/jpeg', 'image/png'];
                        return $file->getSize() <= 2 * 1024 * 1024 && in_array($file->getClientMediaType(), $validTypes) && in_array($ext, ['jpg', 'jpeg', 'png']);
                    }

                    return true; // allow empty on update
                },
                'message' => 'Only JPG or PNG under 2MB allowed.',
            ])
            ->add('photo', 'extension', [
                'rule' => ['extension', ['jpg', 'jpeg', 'png']],
                'message' => 'Only JPG or PNG files are allowed',
            ]);

        $validator
            ->scalar('state_id')
            ->requirePresence('state_id', 'create')
            ->notEmptyString('state_id', 'State is required.');

        $validator
            ->scalar('district_id')
            ->requirePresence('district_id', 'create')
            ->notEmptyString('district_id', 'District is required.');

        $validator
            ->dateTime('created_at')
            ->notEmptyDateTime('created_at');

        $validator
            ->dateTime('updated_at')
            ->notEmptyDateTime('updated_at');

        return $validator;
    }
}
