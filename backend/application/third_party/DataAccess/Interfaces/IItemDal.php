<?php

interface IItemDal {

    function list($id);
    function add($data);
    function update($data);
    function delete($id);
}