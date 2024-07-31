<?php

namespace Mohin\Framework\Routing;



use Mohin\Framework\Http\Request;

interface RouterInterface
{
    public function dispatch(Request $request): array;
}