<?php

namespace App\Expansions\Database;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder as IlluminateSeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

abstract class Seeder extends IlluminateSeeder
{
    abstract public function run();

    final protected function truncate(string ...$models)
    {
        Schema::disableForeignKeyConstraints();

        array_map(function ($model) {
            $table = $this->table($model);

            DB::table($table)->truncate();
        }, $models);

        Schema::enableForeignKeyConstraints();
    }

    final private function table(string $model): string
    {
        return $this
            ->model($model)
            ->getTable();
    }

    /**
     * @param string $model
     *
     * @return Model
     */
    final private function model(string $model)
    {
        return new $model;
    }
}