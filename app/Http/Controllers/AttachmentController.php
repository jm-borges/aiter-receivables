<?php

namespace App\Http\Controllers;

use App\Http\Requests\Attachments\AddAttachmentRequest;
use App\Http\Requests\Attachments\DestroyAttachmentRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Spatie\MediaLibrary\HasMedia;
use App\Http\Controllers\Controller;

class AttachmentController extends Controller
{
    /**
     * Add an attachment to the specified model.
     *
     * @param AddAttachmentRequest $request
     * @return JsonResponse
     */
    public function addAttachment(AddAttachmentRequest $request): JsonResponse
    {
        /** @var Model|HasMedia $model */
        $model = App::make($request->model);
        /** @var Model|HasMedia $model */
        $model = $model->find($request->model_id);
        if ($model) {
            $attachment = $model->addMedia($request->file('file'))->toMediaCollection($request->collection_name ?? 'files');
            return response()->json($attachment);
        } else {
            return response()->json(['message' => 'Model with this ID not found'], 404);
        }
    }

    /**
     * Destroy all attachments of the specified model.
     *
     * @param DestroyAttachmentRequest $request
     * @return JsonResponse
     */
    public function destroyAllAttachment(DestroyAttachmentRequest $request): JsonResponse
    {
        /** @var Model|HasMedia $model */
        $model = App::make($request->model);
        /** @var Model|HasMedia $model */
        $model = $model->find($request->model_id);
        if ($model) {
            $model->clearMediaCollection($request->collection_name ?? 'files');
            return response()->json(['message' => 'Deletado com sucesso']);
        } else {
            return response()->json(['message' => 'Model with this ID not found'], 404);
        }
    }
}
