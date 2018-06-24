<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\User;

class UserController extends ApiController
{
    /**
     * @var UserRepository
     */
    protected $userRepository;


    /**
     * UserController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct( UserRepository $userRepository )
    {
        $this->middleware( 'api.auth', ['only' => ['show']] );

        $this->userRepository = $userRepository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Pagination\Paginator
     */
    public function index(Request $request)
    {
        return $this->userRepository->page((int) $request->query('limit'));
    }

    /**
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function show($id, Request $request)
    {
        return $this->userRepository->getById((int)$id);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store(Request $request)
    {
        return $this->userRepository->store($request->all());
    }


    /**
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update($id, Request $request)
    {
        return $this->userRepository->update((int) $id, $request->all());
    }

    /**
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function destroy($id, Request $request)
    {
        return $this->userRepository->delete((int) $id);
    }

}
