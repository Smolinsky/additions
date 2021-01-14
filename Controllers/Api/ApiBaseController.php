<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Traits\ResponseTrait;
use App\Http\Controllers\Api\Traits\UuidFindTrait;
use App\Models\User;
use Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/**
 * Class ApiBaseController
 * @package App\Http\Controllers\Api
 */
abstract class ApiBaseController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, ResponseTrait, UuidFindTrait;

    /**
     * Illuminate\Http\Request instance.
     *
     * @var Request
     */
    protected $request;

    /**
     * Number of items displayed at once if not specified.
     * There is no per_page if it is 1 or false.
     *
     * @var int|bool
     */
    protected $defaultPerPage = 100;

    /**
     * Maximum per_page that can be set via $_GET['per_page'].
     *
     * @var int|bool
     */
    protected $maximumPerPage = 200;

    /**
     * Default per_page that can be set via $_GET['per_page'].
     *
     * @var int
     */
    protected $perPage;

    /**
     * Default page that can be set via $_GET['page'].
     *
     * @var int
     */
    protected $page;

    /**
     * Allows includes relationship.
     * There is no limit if it is [], and all includes denied if it is null.
     *
     * @var array|null
     */
    protected $allowsWith = [];

    /**
     * Includes relationship that can be set via $_GET['include'].
     *
     * @var array
     */
    protected $with = [];

    /**
     * Get authorized user
     *
     * @var User|null
     */
    protected $user;

    /**
     * Constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->user = Auth::user();
        $this->perPage = $this->calculatePerPage();
        $this->page = $this->calculatePage();
        $this->with = $this->getWith();
    }

    /**
     * Calculates per_page for a number of items displayed in list.
     *
     * @return int
     */
    protected function calculatePerPage(): int
    {
        $per_page = (int)$this->request->input('per_page', $this->defaultPerPage);
        $per_page = ($this->maximumPerPage && $this->maximumPerPage < $per_page) ? $this->maximumPerPage : $per_page;

        return $per_page ? $per_page : (int)$this->defaultPerPage;
    }

    /**
     * Calculates page number for displayed in list.
     *
     * @return int
     */
    protected function calculatePage(): int
    {
        return (int)$this->request->input('page', 1);
    }

    /**
     * Specify relations for eager loading.
     *
     * @return array
     */
    protected function getWith()
    {
        $include = camel_case($this->request->input('include', ''));
        $includes = explode(',', $include);
        $includes = array_filter($includes);
        $includes = $includes ?: [];

        if (is_array($this->allowsWith) && !empty($this->allowsWith)) {
            $includes = array_intersect($this->allowsWith, $includes);
        } elseif (is_null($this->allowsWith)) {
            $includes = [];
        }

        return $includes;
    }
}
