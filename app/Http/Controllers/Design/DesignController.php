<?php

namespace App\Http\Controllers\Design;

use App\Http\Controllers\Controller;
use App\Http\Requests\Design\GetDesignListRequest;
use App\Http\Requests\Design\PresetExistsRequest;
use App\Http\Requests\Design\SaveDesignRequest;
use App\Models\DesignPreset;
use Illuminate\Http\Request;

class DesignController extends Controller
{
    /**
     * Получение списка пресетов
     * @param GetDesignListRequest $request
     * @return array
     */
    public function list(GetDesignListRequest $request): array
    {
        $count = DesignPreset::count();
        $design_list = DesignPreset::query()->select('*');
        if($request->get('id') === null){
            if($request->get('count') !== null)
                $design_list = $design_list->take($request->get('count'));
            if($request->get('offset') !== null)
            {
                if($request->get('count') !== null)
                    $design_list = $design_list->skip($request->get('offset'));
                else{
                    $limit = $count - (int)$request->get('offset');
                    $design_list = $design_list->skip($request->get('offset'))->take($limit);
                }
            }

            $design_list = $design_list->get()->makeHidden(['blob']);
        }
        else{
            $design_list = $design_list->where('id', $request->get('id'))->get();
        }

        $this->response['status'] = 'OK';
        $this->response['data'] = $design_list;

        return $this->response;
    }

    /**
     * Сохранение пресета
     * @param SaveDesignRequest $request
     * @return array
     */
    public function savePreset(SaveDesignRequest $request): array
    {
        if($request->post('id') === null){
            $design = new DesignPreset();
        }
        else{
            $design = DesignPreset::query()->where('id', $request->post('id'))->get()->first();
        }
        $design->name = $request->post('name');
        $design->blob = $request->post('blob');
        $design->save();

        $this->response['status'] = 'OK';
        $this->response['data'] = $design;

        return $this->response;
    }

    /**
     * Удаление пресета
     * @param PresetExistsRequest $request
     * @return array
     */
    public function deletePreset(PresetExistsRequest $request): array
    {
        DesignPreset::destroy($request->post('id'));

        $this->response['status'] = 'OK';
        $this->response['data'] = (int)$request->post('id');

        return $this->response;
    }
}
