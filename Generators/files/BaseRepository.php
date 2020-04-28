<?php
namespace App\Repositories;

class BaseRepository
{
    protected $model;
    protected $obj = [];
    protected $returnType = 'error';
    protected $returnMsg = '';
    protected $returnContent = '';
    protected $statusCode = 400;
    protected $options = 0;

    /**
     * Mount return.
     *
     * @return array
     */
    public function mountReturn()
    {
        return (object) [
            'data' => $this->obj,
            'status' => $this->statusCode,
            'headers' => [
                'returnType' => $this->returnType,
                'returnMsg' => $this->returnMsg,
                'returnContent' => $this->returnContent,
            ],
            'options' => $this->options
        ];
    }

    /**
     * List all resources withoutTrashed.
     *
     * @return array
     */
    public function all()
    {
        try{
            $this->obj = $this->model->all();
            $this->returnType = 'success';
            $this->statusCode = 200;
        } catch(\Throwable $th) {
            $this->returnMsg = trans('transations.load.error');
            $this->returnContent = $th->getMessage();
        }

        return $this->mountReturn();
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
            $this->returnType = 'success';
            $this->statusCode = 200;
        } catch(\Throwable $th) {
            $this->returnMsg = trans('transations.load.error');
            $this->returnContent = $th->getMessage();
        }

        return $this->mountReturn();
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
            $this->returnType = 'success';
            $this->statusCode = 200;
        } catch(\Throwable $th) {
            $this->returnMsg = trans('transations.load.error');
            $this->returnContent = $th->getMessage();
        }

        return $this->mountReturn();
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
            $this->returnType = 'success';
            $this->statusCode = 200;
        } catch(\Throwable $th) {
            $this->returnMsg = trans('transations.found.error');
            $this->returnContent = $th->getMessage();
            $this->statusCode = 404;
        }

        return $this->mountReturn();
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
            $this->returnType = 'success';
            $this->returnMsg = trans('transations.create.success');
            $this->statusCode = 201;
        } catch (\Throwable $th) {
            $this->returnMsg = trans('transations.create.error');
            $this->returnContent = $th->getMessage();
            $this->statusCode = 400;
        }

        return $this->mountReturn();
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
            $this->returnType = 'success';
            if(!$res->getChanges()) $this->returnMsg = trans('transations.update.same');
            else $this->returnMsg = trans('transations.update.success');
        } catch (\Throwable $th) {
            $this->returnMsg = trans('transations.update.error');
            $this->returnContent = $th->getMessage();
            $this->statusCode = 400;
        }

        return $this->mountReturn();
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
            $this->returnType = 'success';
            $this->returnMsg = trans('transations.delete.success');
        } catch (\Throwable $th) {
            $this->returnMsg = trans('transations.delete.error');
            $this->returnContent = $th->getMessage();
            $this->statusCode = 400;
        }

        return $this->mountReturn();
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
            $this->returnType = 'success';
            $this->returnMsg = trans('transations.restore.success');
            $this->statusCode = 200;
        } catch (\Throwable $th) {
            $this->returnMsg = trans('transations.restore.error');
            $this->returnContent = $th->getMessage();
            $this->statusCode = 400;
        }

        return $this->mountReturn();
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
            $this->returnType = 'success';
            $this->returnMsg = trans('transations.forceDelete.success');
            $this->statusCode = 200;
        } catch (\Throwable $th) {
            $this->returnMsg = trans('transations.forceDelete.error');
            $this->returnContent = $th->getMessage();
            $this->statusCode = 400;
        }

        return $this->mountReturn();
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

        if($diff) return trans('transations.diff_fields',['expected'=> implode(',',$diff), 'sended' => implode(',', $fillable)]); 
        return false;
    }

}