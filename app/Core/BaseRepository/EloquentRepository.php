<?php
/**
 * Created by PhpStorm.
 * User: Dinh Huong
 * Date: 06/08/18
 * Time: 8:52 AM
 */

namespace App\Core\BaseRepository;

abstract class EloquentRepository implements RepositoryInterface
{
    use ScopeCondition;
    use HelperCondition;

    protected $model;

    protected $array_relation;

    protected $modelPreifx;

    protected $operator = [
        '=',
        '!=',
        '<>',
        '>=',
        '<=',
        '>',
        '<',
        'like',
    ];

    protected function setArrRelation($relation)
    {
        $this->array_relation = $relation;
    }

    /**
     * Lấy ra tất cả bản ghi và có thể lấy cả relation
     * Các filter: $relation, $whereIn, $where, $time, $order
     * @param array $filter
     * @param array $columns
     * @param bool  $paginate
     * @return mixed
     */
    public function getAllRecord($filter = [], $columns = ['*'], $paginate = false)
    {
        $result = $this->model;
        if (!empty($filter))
        {
            $relation   = $filter['relation'] ?? null;
            $join       = $filter['join'] ?? null;
            $whereNotIn = $filter['whereNotIn'] ?? null;
            $whereIn    = $filter['whereIn'] ?? null;
            $where      = $filter['where'] ?? null;
            $orWhere    = $filter['orWhere'] ?? null;
            $order      = $filter['order'] ?? null;
            $limit      = $filter['limit'] ?? null;
            $between    = $filter['between'] ?? null;
            $whereDate  = $filter['whereDate'] ?? null;
            $whereMonth = $filter['whereMonth'] ?? null;
            if ($relation)
            {
                $result = $this->scopeRelation($result, $relation);
            }
            if ($join)
            {
                $result = $this->scopeJoin($result, $join);
            }
            if ($whereIn)
            {
                $result = $this->scopeWhereIn($result, $whereIn);
            }
            if ($whereNotIn)
            {
                $result = $this->scopeWhereNotIn($result, $whereNotIn);
            }
            if ($where)
            {
                $result = $this->scopeWhere($result, $where);
            }
            if ($orWhere)
            {
                $result = $this->scopeOrWhere($result, $orWhere);
            }
            if ($order)
            {
                $result = $this->scopeOrder($result, $order);
            }
            if ($between)
            {
                $result = $this->scopeBetween($result, $between);
            }
            if ($whereDate)
            {
                $result = $this->scopeWhereDate($result, $whereDate);
            }
            if ($whereMonth)
            {
                $result = $this->scopeWhereMonth($result, $whereMonth);
            }
            if ($limit)
            {
                $result = $result->limit($limit);
            }
        }

        return $paginate ? $result->paginate($paginate, $columns) : $result->get($columns);
    }

    /**
     *
     * Các filter: $relation, $where
     * @param       $id
     * @param       $filter
     * @param array $columns
     * @return mixed
     */
    public function findOneRecord($filter, $columns = ['*'])
    {
        if (empty($filter)) return null;

        $result   = $this->model;
        $relation = $filter['relation'] ?? null;
        $where    = $filter['where'] ?? null;
        if ($relation)
        {
            $result = $this->scopeRelation($result, $relation);
        }
        if ($where)
        {
            $result = $this->scopeWhere($result, $where);
        }

        return $result->first($columns);
    }

    /**
     * Tìm bản ghi theo Id và có thể lấy cả relation
     * Các filter: $relation, $where
     * @param       $id
     * @param       $filter
     * @param array $columns
     * @return mixed
     */
    public function findOneById($id, $filter = [], $columns = ['*'])
    {
        $result = $this->model;
        if (!empty($filter))
        {
            $relation = array_get($filter, 'relation');
            $where    = array_get($filter, 'where');

            if ($relation)
            {
                $result = $this->scopeRelation($result, $relation);
            }
            if ($where)
            {
                $result = $this->scopeWhere($result, $where);
            }
        }

        return $result->find($id, $columns);
    }

    public function findOneViaId($id, $columns = ['*'])
    {
        $result = $this->model;
        if (!empty($filter))
        {
            $relation = array_get($filter, 'relation');
            $where    = array_get($filter, 'where');

            if ($relation)
            {
                $result = $this->scopeRelation($result, $relation);
            }
            if ($where)
            {
                $result = $this->scopeWhere($result, $where);
            }
        }

        return $result->find($id, $columns);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function insert(array $data)
    {
        return $this->model->insert($data);
    }

    public function updateById($id, $data = [])
    {
        return $this->model->find($id)->update($data);
    }

    public function update($filter = [], $data = [])
    {
        $result = $this->model;
        if ($where = array_get($filter, 'where'))
        {
            $result = $this->scopeWhere($result, $where);
        }

        return $result->update($data);
    }

    public function updateOrCreate($filter, $data)
    {
        return $this->model->updateOrCreate($filter, $data);
    }

    public function delete($filter)
    {
        $result = $this->model;
        if ($where = array_get($filter, 'where'))
        {
            $result = $this->scopeWhere($result, $where);
        }

        return $result->delete();
    }

    public function destroy($ids)
    {
        return $this->model->destroy($ids);
    }

    public function valueById($id, $column)
    {
        return $this->model->where('id', $id)->value($column);
    }

    public function value($filter = [], $field='id')
    {
        $result = $this->model;
        if ($where = array_get($filter, 'where'))
        {
            $result = $this->scopeWhere($result, $where);
        }

        return $result->value($field);
    }

    public function firstById($id, $columns = ['*'])
    {
        return $this->model->where('id', $id)->first($columns);
    }

    public function first($filter = [], $columns = ['*'])
    {
        $result = $this->model;
        if ($relation = array_get($filter, 'relation'))
        {
            $result = $this->scopeRelation($result, $relation);
        }
        if ($where = array_get($filter, 'where'))
        {
            $result = $this->scopeWhere($result, $where);
        }
        if ($order = array_get($filter, 'order'))
        {
            $result = $this->scopeOrder($result, $order);
        }

        return $result->first($columns);
    }

    public function pluck($filter, $column, $key = null)
    {
        $result = $this->model;
        if ($where = array_get($filter, 'where'))
        {
            $result = $this->scopeWhere($result, $where);
        }
        if ($whereIn = array_get($filter, 'whereIn'))
        {
            $result = $this->scopeWhereIn($result, $whereIn);
        }
        if ($whereMonth = array_get($filter, 'whereMonth'))
        {
            $result = $this->scopeWhereMonth($result, $whereMonth);
        }
        if ($limit = array_get($filter, 'limit'))
        {
            $result = $result->limit($limit);
        }
        if ($groupBy = array_get($filter, 'groupBy'))
        {
            $result = $result->groupBy($groupBy);
        }

        return $result->pluck($column, $key);
    }

    public function increment($id, $field, $number)
    {
        return $this->model->where('id', $id)->increment($field, $number);
    }

    public function count($filter)
    {
        $result = $this->model;
        if ($where = array_get($filter, 'where'))
        {
            $result = $this->scopeWhere($result, $where);
        }
        if ($whereDate = array_get($filter, 'whereDate'))
        {
            $result = $this->scopeWhereDate($result, $whereDate);
        }
        if ($whereMonth = array_get($filter, 'whereMonth'))
        {
            $result = $this->scopeWhereMonth($result, $whereMonth);
        }
        if ($between = array_get($filter, 'between'))
        {
            $result = $this->scopeBetween($result, $between);
        }
        if ($groupBy = array_get($filter, 'groupBy'))
        {
            $result = $this->groupBy($groupBy);
        }

        return $result->count();
    }

    public function storeRecord($data)
    {
        $input = $this->getInputHasData($data);

        return $this->create($input);
    }

    public function updateRecordById($id, $data)
    {
        $input = $this->getInputHasData($data);
        return $this->updateById($id, $input);
    }
}