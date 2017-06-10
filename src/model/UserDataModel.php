<?php
namespace model;

class UserDataModel extends \model\DataModel
{
    private $_tableName = 'UserData';

    public function getTableName()
    {
        return $this->_tableName;
    }

    /*
     * ユーザーデータ取得
     * @return array
     */
    public function getUserData($userId)
    {
        $result = $this
            ->where('userId', '=', $userId)
            ->toArray();

        return $result;
    }

    /*
     * ユーザーデータ登録
     * @param int    $userId
     * @param string $name
     * @param string $password
     * @return bool
     */
    public function insertUserData($userId, $name, $password)
    {
        $result = $this
            ->set('userId',   $userId)
            ->set('name',     $name)
            ->set('password', $password)
            ->save();

        return $result;
    }
}
