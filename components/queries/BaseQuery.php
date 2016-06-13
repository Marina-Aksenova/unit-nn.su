<?php
namespace app\components\queries;

use yii;
use yii\db\ActiveQuery;

class BaseQuery extends ActiveQuery
{
    public function one($db = null)
    {
        $this->preparations();
        return parent::one($db);
    }

    public function all($db = null)
    {
        $this->preparations();
        return parent::all($db);
    }

    public function column($db = null)
    {
        $this->preparations();
        return parent::column($db);
    }

    public function scalar($db = null)
    {
        $this->preparations();
        return parent::scalar($db);
    }

    public function exists($db = null)
    {
        $this->preparations();
        return parent::exists($db);
    }

    public function count($q = '*', $db = null)
    {
        $this->preparations();
        return parent::count($q, $db);
    }

    private function preparations()
    {
    }

}