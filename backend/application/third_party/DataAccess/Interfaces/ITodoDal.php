<?php

interface ITodoDal {

    function all();
    function add($data);
    function update($data);
    function delete($id);
}