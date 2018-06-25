<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\CssSelector\Exception\InternalErrorException;

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
        $this->userRepository = $userRepository;
    }

    /**
     * @param Request $request
     * @return JsonResource
     */
    public function index(Request $request)
    {
        return UserResource::collection( $this->userRepository->page( (int) $request->query( 'limit' ) ) );
    }

    /**
     * @param int $id
     * @param Request $request
     * @return JsonResource
     */
    public function show($id, Request $request)
    {
        return new UserResource( $this->userRepository->getById( (int) $id ) );
    }


    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws InternalErrorException
     */
    public function store(Request $request)
    {
        if ( $user = $this->userRepository->store( $request->all() ) ) {
            $token = \JWTAuth::fromUser( $user );
            return response()->json( compact('token') );
        }
        throw new InternalErrorException('internal_error');
    }


    /**
     * @param int $id
     * @param Request $request
     * @return JsonResource
     */
    public function update($id, Request $request)
    {
        return new UserResource( $this->userRepository->update( (int) $id, $request->all() ) );
    }

    /**
     * @param int $id
     * @param Request $request
     * @return JsonResource
     */
    public function destroy($id, Request $request)
    {
        return new UserResource( $this->userRepository->delete( (int) $id ) );
    }

}
