<?php

namespace DF\Repositories;

interface IRepository
{
    public function findById($id);
    public function remove($id);
}