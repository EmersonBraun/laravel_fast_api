<?php
namespace App\Repositories;

use App\Traits\ResponseTrait;
class BaseRepository
{
    use ResponseTrait;
    
    protected $model;
    protected $obj = [];
    protected $returnMsg = '';
    protected $contentError = '';
    protected $statusCode = 400;
    protected $options = 0;

    /**
     * List all resources withoutTrashed.
     *
     * @return array
     */
    public function all()
    {
        try{
            $this->obj = $this->model->all();
            $this->statusCode = 200;
        } catch(\Throwable $th) {
            $this->contentError = $th->getMessage();
        }

        return $this->mountReturn('load', $this->obj, $this->statusCode, $this->contentError);
    }

    /**
     * List all resources withTrashed.
     *
     * @return array
     */
    public function withTrashed()
    {
        try{
            $this->obj = $this->model->withTrashed()->get();
            $this->statusCode = 200;
        } catch(\Throwable $th) {
            $this->contentError = $th->getMessage();
        }

        return $this->mountReturn('load', $this->obj, $this->statusCode, $this->contentError);
    }

    /**
     * List of resources Trashed.
     *
     * @return array
     */
    public function OnlyTrashed()
    {
        try{
            $this->obj = $this->model->onlyTrashed()->get();
            $this->statusCode = 200;
        } catch(\Throwable $th) {
            $this->contentError = $th->getMessage();
        }

        return $this->mountReturn('load', $this->obj, $this->statusCode, $this->contentError);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return array
     */
    public function findOrFail($id)
    {
        try{
            $this->obj = $this->model->findOrFail($id);
            $this->statusCode = 200;
        } catch(\Throwable $th) {
            $this->contentError = $th->getMessage();
            $this->statusCode = 404;
        }

        return $this->mountReturn('found', $this->obj, $this->statusCode, $this->contentError);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  array
     * @return array
     */
    public function create(array $data)
    {

        try {
            $this->obj = $this->model->create($data);
            $this->statusCode = 201;
        } catch (\Throwable $th) {
            $this->contentError = $th->getMessage();
            $this->statusCode = 400;
        }

        return $this->mountReturn('create', $this->obj, $this->statusCode, $this->contentError);
    }   

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param  array  $data
     * @return array
     */
    public function findAndUpdate($id, array $data)
    {
        $res = $this->model->findOrFail($id);
        try {
            $res->update($data);
            $this->obj = $res->getChanges();
            $this->statusCode = 200;
        } catch (\Throwable $th) {
            $this->contentError = $th->getMessage();
            $this->statusCode = 400;
        }

        return $this->mountReturn('update', $this->obj, $this->statusCode, $this->contentError);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return array
     */
    public function findAndDelete($id)
	{
        try {
            $this->obj = $this->model->find($id)->delete();
            $this->statusCode = 200;
        } catch (\Throwable $th) {
            $this->contentError = $th->getMessage();
            $this->statusCode = 400;
        }

        return $this->mountReturn('delete', $this->obj, $this->statusCode, $this->contentError);
    }

    /**
     * Restore the specified resource from storage.
     * Only from Softdelete
     *
     * @param  int  $id
     * @return array
     */
    public function findAndRestore($id)
	{
        try {
            $this->obj = $this->model->withTrashed()->findOrFail($id)->restore();
            $this->statusCode = 200;
        } catch (\Throwable $th) {
            $this->contentError = $th->getMessage();
            $this->statusCode = 400;
        }

        return $this->mountReturn('restore', $this->obj, $this->statusCode, $this->contentError);
    }

    /**
     * Remove permanent the specified resource from storage.
     * Only from Softdelete
     *
     * @param  int  $id
     * @return array
     */
    public function findAndDestroy($id)
	{
        try {
            $this->obj = $this->model->withTrashed()->findOrFail($id)->forceDelete();
            $this->statusCode = 200;
        } catch (\Throwable $th) {
            $this->contentError = $th->getMessage();
            $this->statusCode = 400;
        }

        return $this->mountReturn('forceDelete', $this->obj, $this->statusCode, $this->contentError);
    }

    /**
     * Comparate data sended with fields from database table.
     *
     * @param  array  $data
     * @return array
     */
    public function compareFields(array $data)
    {
        $fillable = $this->model->getFillable();
        $send = array_keys($data);

        if($diff) return trans('transation.diff_fields',['expected'=> implode(',',$diff), 'sended' => implode(',', $fillable)]); 
        return false;
    }

}