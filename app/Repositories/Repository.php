<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use League\Fractal\Resource\Collection;

trait Repository
{


    /**
     * @return array
     */
    public function getNumber()
    {
        return $this->model->count();
    }

    /**
     * @param int $id
     * @return Model
     */
    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Get all the records
     *
     * @return array Model
     */
    public function all()
    {
        return $this->model->get();
    }

    /**
     * Get number of the records
     *
     * @param  int $number
     * @param  string $sort
     * @param  string $sortColumn
     * @return Paginator
     */
    public function page($number = 10, $sort = 'desc', $sortColumn = 'ID')
    {
        return $this->model->orderBy($sortColumn, $sort)->paginate($number);
    }

    /**
     * Get record by the slug.
     *
     * @param  string $slug
     * @return Collection
     */
    public function getBySlug($slug)
    {
        return $this->model->where('slug', $slug)->first();
    }

    /**
     * @param $input
     * @return Model
     */
    public function store($input)
    {
        return $this->save($this->model, $input);
    }

    /**
     * @param $id
     * @param $input
     * @return Model
     */
    public function update($id, $input)
    {
        $this->model = $this->getById($id);
        return $this->save($this->model, $input);
    }

    /**
     * @param int $id
     * @return Model
     */
    public function delete($id)
    {
        $this->model = $this->getById($id);
        $this->model->delete();

        return $this->model;
    }

    /**
     * @param Model $model
     * @param array $input
     * @return Model
     */
    protected function save($model, $input)
    {
        $model->fill($input);
        $model->save();
        return $model;
    }
}
