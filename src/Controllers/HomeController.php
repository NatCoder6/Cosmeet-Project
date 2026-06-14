<?php

// COSMEET — Home Controller

namespace Cosmeet\Controllers;

use Cosmeet\Models\MissionModel;

class HomeController extends BaseController {

    public function index(): void {
        $missionModel = new MissionModel();
        $featured = $missionModel->getFeatured(4);
        $this->view('home/index', [
            'title'    => 'Cosmeet — Begin Your Space Journey',
            'featured' => $featured,
        ]);
    }
}
