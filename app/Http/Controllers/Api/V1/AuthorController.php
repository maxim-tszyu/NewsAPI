<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreAuthorRequest;
use App\Http\Resources\Api\V1\AuthorResource;
use App\Http\Resources\Api\V1\NewsResource;
use App\Models\Author;

class AuthorController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/authors",
     *     tags={"Authors"},
     *     summary="Получить список авторов",
     *     description="Возвращает пагинированный список всех авторов, отсортированных по ФИО в порядке убывания.",
     *     @OA\Response(
     *         response=200,
     *         description="Успешный ответ со списком авторов",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/AuthorResource")
     *             ),
     *             @OA\Property(property="links", type="object"),
     *             @OA\Property(property="meta", type="object")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return AuthorResource::collection(
            Author::orderBy('full_name', 'desc')
                ->paginate(20)
                ->withQueryString()
        );
    }

    /**
     * @OA\Get(
     *     path="/api/v1/authors/{id}",
     *     tags={"Authors"},
     *     summary="Получить все новости конкретного автора",
     *     description="Возвращает список новостей, написанных указанным автором, включая рубрики и самого автора.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID автора",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Успешный ответ с новостями автора",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(ref="#/components/schemas/NewsResource")
     *             ),
     *             @OA\Property(property="links", type="object"),
     *             @OA\Property(property="meta", type="object")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Автор не найден")
     * )
     */
    public function show(Author $author)
    {
        $news = $author->news()
            ->with('rubrics', 'author')
            ->orderBy('publish_date', 'desc')
            ->paginate(20)
            ->withQueryString();

        return NewsResource::collection($news);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/authors",
     *     tags={"Authors"},
     *     summary="Создать нового автора",
     *     description="Добавляет нового автора в базу данных. Прикреплённый аватар сохраняется в публичном хранилище.",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"full_name", "email"},
     *                 @OA\Property(property="full_name", type="string", example="Айболат Кулатай"),
     *                 @OA\Property(property="email", type="string", example="aibolat@example.com"),
     *                 @OA\Property(property="avatar", type="string", format="binary", description="Файл аватарки (необязательно)")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Автор успешно создан",
     *         @OA\JsonContent(ref="#/components/schemas/AuthorResource")
     *     ),
     *     @OA\Response(response=401, description="Неавторизован"),
     *     @OA\Response(response=422, description="Ошибка валидации")
     * )
     */
    public function store(StoreAuthorRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $author = Author::create($validated);

        return new AuthorResource($author);
    }
}
