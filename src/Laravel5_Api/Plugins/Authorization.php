<?php

namespace SehrGut\Laravel5_Api\Plugins;

use Illuminate\Foundation\Auth\User as DummyUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use SehrGut\Laravel5_Api\Context;
use SehrGut\Laravel5_Api\Exceptions\Unauthorized;
use SehrGut\Laravel5_Api\Hooks\AuthorizeAction;
use SehrGut\Laravel5_Api\Hooks\AuthorizeResource;

/**
 * This plugin checks for Policies or Gate Closures for an action or a single resource.
 */
class Authorization extends Plugin implements AuthorizeAction, AuthorizeResource
{
    /** {@inheritdoc} */
    public function authorizeAction(Context $context)
    {
        if (Gate::forUser($this->authenticatedUserOrDummy())->denies(
            $context->action,
            $context->model
        )) {
            throw new Unauthorized();
        }

        return $context;
    }

    /** {@inheritdoc} */
    public function authorizeResource(Context $context)
    {
        if (Gate::forUser($this->authenticatedUserOrDummy())->denies(
            $context->action,
            $context->resource
        )) {
            throw new Unauthorized();
        }

        return $context;
    }

    /**
     * Laravel assumes an authenticated User object for any authorization.
     *
     * There might be situations where you don't have or need an User in
     * your authorisation logic. For those situations we will simply
     * create a DummyUser which contains no information in order
     * to satisfy Laravel's authorisation logic.
     *
     * @return Illuminate\Foundation\Auth\User
     */
    protected function authenticatedUserOrDummy()
    {
        return Auth::user() ?: new DummyUser();
    }
}
