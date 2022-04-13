<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->post('/settings/update_password', function (Request $request, Response $response) use ($app) {

    $tainted = $request->getParsedBody();
    $current = $tainted['current_password'];
    $password_first = $tainted['password_first'];
    $password_second = $tainted['password_second'];
    $userId =  $_SESSION['userId'];
    $database = $app->getContainer()->get('database');
    //Hash new Password
    $hash = currentPassword($current,$database, $userId);
    $verified_password = verifying($password_first,$password_second, $app, $hash);

  if($verified_password)
  {
      if($database->updatePassword($userId, $verified_password))
      {
          $database->logActivity($userId, 'Password updated successfully.');
          return $response->withRedirect(URL_root . '/dashboard');
      }else{
          $_SESSION['updateError'] = 1;
          $database->logActivity($userId, 'Error updating password.');
          return $response->withRedirect(URL_root . '/settings');
      }
  }else{
      $_SESSION['updateError'] = 1;
      $database->logActivity($userId, 'Error updating password.');
       return $response->withRedirect(URL_root . '/settings');
  }
});

function verifying($password_first, $password_second, $app, $current)
{
    if(twoNewMatch($password_first, $password_second))
    {
        if(checkNewPassword($password_first))
        {
            $new_hash = hashPassword($app, $password_first);
            if(compareNewOld($new_hash, $current))
            {
                return $new_hash;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }else{
        return false;
    }
}

function hashPassword($app, $password)
{
    return $app->getContainer()->get('bcryptWrapper')->generateHash($password);
}

function compareNewOld($new_password, $old_password)
{
    if($new_password != $old_password)
    {
        return true;
    }else{ return false; }
}

function twoNewMatch($password_one, $password_two)
{
    if($password_one == $password_two)
        return true;
    else
        return false;
}

function checkNewPassword($password)
{
    // Validate password strength
    $upper = preg_match('@[A-Z]@', $password);
    $lower = preg_match('@[a-z]@', $password);
    $num    = preg_match('@[0-9]@', $password);
    $special = preg_match('@[^\w]@', $password);

    if(!$upper || !$lower || !$num || !$special || strlen($password) < 8) {
        return false;
    }else{
        return true;
    }
}

function currentPassword($database,$userId){
    return $database->getUserPassword($userId);;
}