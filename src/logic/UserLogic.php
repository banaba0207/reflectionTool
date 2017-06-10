<?php
namespace logic;

use model\UserDataModel;

class UserLogic
{
    /*
     * ユーザーデータ取得
     * @return array
     */
    public function getUserData($userId)
    {
        $userDataModel = new UserDataModel();
        return $userDataModel->getUserData($userId);
    }

     /*
      * ユーザーデータ登録
      * @param int    $userId
      * @param string $name
      * @param string $password
      * @return bool
      */
    public function addUserData($userId, $name, $password)
    {
        $userDataModel = new UserDataModel();

        // passwordハッシュ化
        $password = password_hash($password, PASSWORD_DEFAULT);

        return $userDataModel->insertUserData($userId, $name, $password);
    }

    /*
     * ユーザーデータ認証
     * @param int    $userId
     * @param string $password
     * @return bool
     */
   public function authentication($userId, $password)
   {
       $userDataModel = new UserDataModel();

       $userData = $userDataModel->getUserData($userId);

       if(empty($userData)) {
           return false;
       }

       $passwordHash = $userData["password"];

       return password_verify($passward, $passwordHash);
   }
}
