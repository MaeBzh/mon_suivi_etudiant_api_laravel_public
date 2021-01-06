<?php


namespace App\Repositories;

interface RepositoryInterface
{

    /**
     * getModel
     *
     * @return void
     */
    public function getModel();


    /**
     * setModel
     *
     * @return void
     */
    public function setModel();


    /**
     * store
     *
     * @return void
     */
    public function store();

    /**
     * update
     *
     * @return void
     */
    public function update();

    /**
     * delete
     *
     * @return void
     */
    public function delete();
}
