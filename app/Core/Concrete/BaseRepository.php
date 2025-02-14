<?php 


namespace App\Core\Concrete;

use App\Core\Abstract\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
    
    public function all()
    {
        return $this->model::all();
    }

    public function find(int $id)
    {
        return $this->model::find($id);
    }

    public function create(array $data)
    {
        return $this->model::create($data);
    }

    public function update(int $id, array $data)
    {
        $model = $this->model::find($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id)
    {
        $model = $this->model::find($id);
        $model->delete();
        return true;
    }

    public function filter(array $filters)
    {
        return $this->model::where($filters)->get();
    }

    public function filterFirst(array $filters)
    {
        return $this->model::where($filters)->first();
    }

}
