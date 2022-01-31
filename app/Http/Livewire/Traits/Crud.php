<?php 

namespace App\Http\Livewire\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

trait Crud 
{

    use AuthorizesRequests;

    public function crudToggle(int $id, string $row): bool
    {
        $model = $this->getModelWithAuthorize('update', $id);
        $model->toggle($row);
        $toggled = !empty($model->getChanges()[$row]);
        $this->crudEmitResult($toggled);
        return $toggled;
    }

    public function crudStore(array $data): Model
    {
        $this->authorize('create', $this->class);
        \DB::beginTransaction();
        $model = app()->make($this->class)->create($data);
        \DB::commit();
        $this->crudEmitResult($model->exists);
        return $model;
    }    

    public function crudDelete(int $id): bool
    {
        $model = $this->getModelWithAuthorize('delete', $id);
        $deleted = $model->delete();
        $this->crudEmitResult($deleted);
        return $deleted;
    }

    public function crudUpdate(int $id, array $data = []): bool
    {
        $model = $this->getModelWithAuthorize('update', $id);
        \DB::beginTransaction();
        $updated = $model->update($data);
        \DB::commit();
        $this->crudEmitResult($updated);
        return $updated;
    }

    public function getModelWithAuthorize(string $action, int $id): Model
    {
        $model = $this->getModel($id);
        $this->authorize($action, $model);
        return $model;
    }

    private function getModel(int $id): Model
    {
        return app()->make($this->class)->findOrFail($id);
    }

    private function crudEmitResult(bool $condition): void
    {
        $this->emit($condition ? 'success' : 'error');
    }

}