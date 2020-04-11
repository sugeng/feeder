<?php namespace Wongpinter\Feeder\Models;
use Wongpinter\Feeder\Contracts\FeederModelInterface;

/**
 * Created By: Sugeng
 * Date: 2019-08-13
 * Time: 23:27
 */
class Base implements FeederModelInterface
{
    protected $table;
    protected $filter = '';
    protected $limit;
    protected $offset;
    protected $soap;
    protected $token;
    protected $orderBy = '';

    public function __construct()
    {
        $soap = app("soap.client");
        $this->soap = $soap->proxy();
        $this->token = $soap->token(); //cache(config('forlap.token-name'));
    }

    public function tables()
    {
        if ($records = $this->soap->ListTable($this->token)) {
            return ($records['result']) ?: $records;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function dictionary()
    {
        $records = $this->soap->GetDictionary($this->token, $this->table);

        if (isset($records['result'])) {
            return $records['result'];
        }

        return false;
    }

    public function paginate($limit, $offset = 0)
    {
        $request = app('request');

        $this->limit($limit, $offset);

        if (! is_null($page = $request->get('page'))) {
            $offset = ($page - 1) * $this->limit;
            $this->limit($limit, $offset);
        }

        $data = [];

        $count   = $this->count();

        $data['offset']      = $offset;
        $data['header']      = $this->dictionary();
        $data['records']     = $this->get();
        $data['total_pages'] = ceil($count / $this->limit);
        $data['currentPage'] = (!is_null($page)) ? $page : 1;

        return $data;
    }

    public function table($table)
    {
        $this->table = $table;

        return $this;
    }

    public function filter($filter)
    {
        $this->filter = $filter;

        return $this;
    }

    public function orderBy($order)
    {
        $this->orderBy = $order;

        return $this;
    }

    public function limit($limit, $offset = 0)
    {
        $this->limit = $limit;
        $this->offset = $offset;

        return $this;
    }

    public function insert($data)
    {
        return $this->soap->InsertRecord($this->token, $this->table, json_encode($data));
    }

    public function insertBatch($data)
    {
        return $this->soap->InsertRecordset($this->token, $this->table, json_encode($data));
    }

    public function update($key, $data)
    {
        return $this->soap->UpdateRecord($this->token, $this->table, json_encode([ 'key' => $key, 'data' => $data ]));
    }

    public function updateBatch($data)
    {
        return $this->soap->UpdateRecordset($this->token, $this->table, json_encode($data));
    }

    public function get()
    {
        $records = $this->soap->GetRecordset($this->token, $this->table, $this->filter, $this->orderBy, $this->limit, $this->offset);

        if (isset($records['result'])) return $records['result'];

        return null;
    }

    public function first()
    {
        $record = $this->soap->GetRecord($this->token, $this->table, $this->filter);

        if (isset($record['result'])) return $record['result'];

        return null;
    }

    public function delete($data)
    {
        return $this->soap->DeleteRecord($this->token, $this->table, json_encode($data));
    }

    public function restore($data)
    {
        return $this->soap->restoreRecordset($this->token, $this->table, json_encode($data));
    }

    public function deleteBatch($data)
    {
        return $this->soap->DeleteRecordset($this->token, $this->table, json_encode($data));
    }

    public function count()
    {
        $record = $this->soap->GetCountRecordset($this->token, $this->table, $this->filter);

        if (isset($record['result'])) return $record['result'];

        return null;
    }

    public function search($filter)
    {
        return $this->filter($filter)->first();
    }
}
