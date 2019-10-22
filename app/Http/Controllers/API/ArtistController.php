<?php

namespace App\Http\Controllers\API;

use App\Artist;
use App\Http\Controllers\Controller;
use App\Http\Requests\Artist\ArtistStoreRequest;
use App\Http\Resources\ArtistResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\QueryBuilder;

class ArtistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,permission:management.artists.store')->only('store');
        $this->middleware('auth:api,permission:management.artists.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $query = QueryBuilder::for(Artist::class)
            ->allowedFields('id', 'name', 'avatar')
            ->allowedFilters('name')
            ->allowedSorts('name')
            ->withCount('songs');

        if (!$request->has('showall')) {
            $query = $query->jsonPaginate();
        } else {
            $query = $query->get();
        }

        return ArtistResource::collection($query);
//        if ($request->has('showall')) {
//            $artists = Artist::select('name')->orderBy('name')->get();
//
//            return ArtistResource::collection($artists);
//        } else {
//            $limit = $request->get('limit') ?? 10;
//            $artists = Artist::paginate($limit);
//
//            return ArtistResource::collection($artists)->response()->setStatusCode(201);
//        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ArtistStoreRequest $request
     * @return ArtistResource
     */
    public function store(ArtistStoreRequest $request)
    {
        $artist = Artist::create($request->all());

        return new ArtistResource($artist);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Artist $artist
     * @return \Illuminate\Http\Response
     */
    public function show(Artist $artist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Artist $artist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Artist $artist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Artist $artist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Artist $artist)
    {
        try {
            $artist->delete();
            \Storage::delete($artist->avatar);

            return response()->json([
                'message' => 'Xóa thành công ca sĩ: ' . $artist->name
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Đã xảy ra lỗi khi xóa ca sĩ'
            ])->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
