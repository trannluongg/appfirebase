<?php
/**
 * Created by PhpStorm.
 * User: Dinh Huong
 * Date: 06/08/18
 * Time: 8:51 AM
 */

namespace App\Core\BaseRepository;

interface RepositoryInterface
{
    public function getAllRecord($filter = [], $columns = ['*'], $paginate = false);

    public function findOneRecord($filter, $columns = ['*']);

    public function findOneById($id, $filter = [], $columns = ['*']);

    public function findOneViaId($id, $columns = ['*']);

    public function create(array $data);

    public function insert(array $data);

    public function updateById($id, $data = []);

    public function update($filter = [], $data = []);

    public function delete($filter);

    public function destroy($ids);

    public function valueById($id, $column);

    public function value($filter = [], $field = 'id');

    public function firstById($id, $columns = ['*']);

    public function first($filter = [], $columns = ['*']);

    public function pluck($filter, $column, $key = null);

    public function count($filter);

    public function storeRecord($data);

    public function updateRecordById($id, $data);
}

