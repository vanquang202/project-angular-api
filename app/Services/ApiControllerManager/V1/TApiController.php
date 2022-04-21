<?php

namespace App\Services\ApiControllerManager\V1;

use Illuminate\Routing\Pipeline;

trait TApiController
{


    public function a_all($limit = 10, $withManyQuerys = [],  $queryAdds = [])
    {

        // try {
        $model = app(Pipeline::class)
            ->send($this::query())
            ->through($queryAdds)
            ->thenReturn()
            ->with($withManyQuerys)
            ->paginate($limit);
        return $model;
        // } catch (\Throwable $th) {
        //     return false;
        // }
    }

    public function a_create($data)
    {
        try {
            if (isset($data['image'])) {
                $nameImage = uniqid() . '.' . $data['image']->getClientOriginalExtension();
                $nameImage2 = $nameImage;
                $data['image']->move(public_path('images'), $nameImage);
                $data['image']  = $nameImage;
            } elseif (isset($data['images'])) {
                foreach ($data['images'] as $image) {
                    $nameImage = uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('images'), $nameImage);
                    $dataSave = \Arr::except($data, ['images']);
                    $dataSave['image']  = $nameImage;
                    $this::create($dataSave);
                }
                return true;
            };
            $d = $this::create($data);
            return $d;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public  function  a_show($id, $withManyQuerys = [])
    {
        try {
            $data = $this::find($id)->load($withManyQuerys);
            return $data;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function a_update($data, $id)
    {
        try {

            $model = $this::find($id);

            if (isset($data['image'])) {
                $nameImage = uniqid() . '.' . $data['image']->getClientOriginalExtension();
                $data['image']->move(public_path('images'), $nameImage);
                $data['image']  = $nameImage;
                if (file_exists(public_path('images') . '\\' . $model->image)) {
                    unlink(public_path('images') . '\\' . $model->image);
                }
            };

            $d = $model->update($data);
            return $d;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function a_destroy($id)
    {
        try {
            $model = $this::find($id);
            if (isset($model->image)) {
                if (file_exists(public_path('images') . '\\' . $model->image)) {
                    unlink(public_path('images') . '\\' . $model->image);
                };
            };
            $model->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}