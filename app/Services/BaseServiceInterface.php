<?php

namespace App\Services;

interface BaseServiceInterface
{
    public function find($id);

    public function create($attributes = []);

    public function update($id, $attributes = []);

    public function delete($id);
}