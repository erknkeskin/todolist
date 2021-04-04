<?php

interface ITodoDal {

    function all($user_id);
    function add($data);
    function update($data);
    function delete($todo_id, $todo_user_id);
    function done($todo_id, $todo_user_id, $todo_status);
}