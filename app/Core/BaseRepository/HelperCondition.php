<?php

namespace App\Core\BaseRepository;

use Illuminate\Support\Facades\Schema;

trait HelperCondition
{
    public function setRelationshipCondition($relation, $relationship)
    {
        if (is_string($relation))
        {
            $relation_array = explode(',', $relation);
        }
        $result = [];
        foreach ($relation_array as $i => $item)
        {
            $result[$i] = [
                'name'  => $item,
                'field' => $relationship[$item] ?? ['*'],
            ];
        }

        return $result;
    }

    protected function buildRelation($relation, &$filter)
    {
        $relas = explode(',', $relation);
        foreach ($relas as $item)
        {
            // Kiểm tra xem quan hệ truyền vào có hợp lệ ko
            if (in_array($item, array_keys($this->array_relation)))
            {
                $filter['relation'][] = [
                    'name'  => $item,
                    'field' => $this->array_relation[$item] ?? '*',
                ];
            }
        }

    }

    protected function buildWhere($col, $con, $val, &$filter)
    {
        $prefix = $this->modelPreifx ?? ($this->model::PREFIX ?? '');
        if ($prefix && !in_array($col, ['id', 'created_at', 'updated_at']))
        {
            $col = $prefix . '_' . $col;
        }
        $filter['where'][] = [$col, $con, $val];
    }

    protected function buildWhereIn($col, $val, &$filter)
    {
        $prefix = $this->modelPreifx ?? ($this->model::PREFIX ?? '');
        if ($prefix && !in_array($col, ['id', 'created_at', 'updated_at']))
        {
            $col = $prefix . '_' . $col;
        }
        $filter['whereIn'] = [$col, $val];
    }

    /*
     * Transform cột muốn lấy sao cho dữ liệu trả về sẽ là 1 mảng
     */
    protected function getColumns($columns, $prefix = '')
    {
        if ($columns)
        {
            if (is_string($columns))
            {
                $arrColumns = explode(',', $columns);
                $prefix     = $this->model::PREFIX ?? $prefix;
                if ($prefix)
                {
                    $responColumn = [];
                    foreach ($arrColumns as $item)
                    {
                        if (in_array($item, ['id', 'created_at', 'updated_at']))
                        {
                            $responColumn[] = $item;
                        }
                        else
                        {
                            $responColumn[] = $prefix . '_' . $item;
                        }
                    }

                    return $responColumn;
                }

                return $arrColumns;
            }
        }

        return ['*'];
    }

    /*
     * Order phân tách nhau bởi __
     * VD: order=id__desc
     */
    protected function getOrder($order, $prefix = '')
    {
        if (empty($prefix))
        {
            $prefix = $this->model::PREFIX;
        }
        if ($order)
        {
            $orders = explode('__', $order);
            if (count($orders) == 2)
            {
                list($col, $sort) = $orders;
                $sort = in_array($sort, ['asc', 'desc']) ? $sort : 'asc';
                if (!in_array($col, ['id', 'created_at', 'updated_at']))
                {
                    $col = $prefix ? $prefix . '_' . $col : $col;
                }

                return $col . ',' . $sort;
            }
        }

        return 'id,asc';
    }

    protected function getInputHasData($data, $prefix = '')
    {
        $input  = [];
        $prefix = $prefix ?: $this->model::PREFIX;
        foreach ($data as $key => $item)
        {
            if (in_array($key, ['id', 'created_at', 'updated_at']))
            {
                $input[$key] = $item;
                continue;
            }
            $input[$prefix . '_' . $key] = $item;
        }
        $input = array_only($input, $this->getColumnListing($this->model));

        return $input;
    }

    /**
     * @param $model
     * @return array
     *
     * Trả về danh sách tên cách cột
     */
    protected function getColumnListing($model)
    {
        return Schema::getColumnListing($model->getTable());
    }
}
