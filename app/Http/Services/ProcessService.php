<?php

namespace App\Http\Services;


class ProcessService
{
    public function formatJson($data){
        return json_encode($data);
}
}
