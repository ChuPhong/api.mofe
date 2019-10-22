<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Song\SongStoreRequest;
use App\Http\Resources\SongResource;
use App\Song;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class SongController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('index', 'show', 'info');
//        $this->middleware('permission:management.songs.all')->only('index');
        $this->middleware('permission:management.songs.destroy')->only('destroy');
    }

    public function info() {
        $allSongs = Song::count();
        $allViews = Song::sum('views');

        return response()->json([
            'data' => [
                'all_songs' => $allSongs,
                'all_views' => $allViews
            ]
        ]);
    }

    /**
     * Trả về danh sách bài hát
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $query = QueryBuilder::for(Song::class)
            ->allowedFields('artists.name', 'id', 'name', 'thumbnail', 'views')
            ->allowedIncludes('artists')
            ->allowedSorts('views', 'id', 'created_at', 'updated_at')
            ->allowedFilters('name', AllowedFilter::scope('search'))
            ->allowedAppends('slug');

        if ($request->has('random') && $request->get('random') === 'true') {
            $query = $query->inRandomOrder();
        }

        $query = $query->jsonPaginate();

        return SongResource::collection($query);


//        if ($request->has('page') || $request->has('per_page')) {
//            return $queryBuilder
//                ->jsonPaginate($request->get('per_page') ?? 2)
//                ->appends(request()->query());
//        } else {
//            return $queryBuilder->get();
//        }


//        $limit = $request->get('per_page') ?? 10;
//
//        if ($request->has('q')) {
//            $value = $request->get('q');
//            $songs = Song::findByNameOrArtist($value)->paginate($limit);
//        } else if ($request->has('order_by')) {
//            $value = $request->get('order_by') ?? 5;
//            if ($value > 5) $value = 5;
//            $songs = Song::orderByDesc('views')->limit($value)->get();
//        } else {
//            $songs = Song::paginate($limit);
//        }
//
//        return SongResource::collection($songs)->response()->setStatusCode(Response::HTTP_PARTIAL_CONTENT);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SongStoreRequest $request
     * @return SongResource
     */
    public function store(SongStoreRequest $request)
    {
        $song = Song::create($request->all())->setArtist($request->get('artists'));
        $song->refresh();

        return new SongResource($song);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Song $song
     * @return SongResource
     */
    public function show(Song $song)
    {
        return new SongResource($song->load('artists:name'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Song $song
     * @return SongResource
     */
    public function update(Request $request, Song $song)
    {
        $currentView = $song->views;
        $updateViews = $request->get('views');

        if (($currentView + 1) !== $updateViews)
        {
            $updateViews = $currentView + 1;
        }

        $data = array_merge($request->all(), ['views' => $updateViews]);

        $song->update($data);

        return new SongResource($song);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Song $song
     * @return \Illuminate\Http\Response
     */
    public function destroy(Song $song)
    {
        try {
            $song->delete();
            \Storage::delete($song->url);
            \Storage::delete($song->thumbnail);

            return response()->json([
                'message' => 'Xóa thành công bài hát: ' . $song->name
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Đã xảy ra lỗi khi xóa bài hát'
            ])->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
