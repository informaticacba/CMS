<?php

/**
 * This file is part of Bootstrap CMS by Graham Campbell.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 */

namespace GrahamCampbell\BootstrapCMS\Controllers;

use Illuminate\Support\Facades\Response;
use GrahamCampbell\Viewer\Facades\Viewer;
use GrahamCampbell\CMSCore\Facades\FileProvider;
use GrahamCampbell\Credentials\Classes\Credentials;
use GrahamCampbell\CMSCore\Controllers\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * This is the file controller class.
 *
 * @package    Bootstrap-CMS
 * @author     Graham Campbell
 * @copyright  Copyright (C) 2013-2014  Graham Campbell
 * @license    https://github.com/GrahamCampbell/Bootstrap-CMS/blob/master/LICENSE.md
 * @link       https://github.com/GrahamCampbell/Bootstrap-CMS
 */
class FileController extends AbstractController
{
    /**
     * Create a new instance.
     *
     * @param  \GrahamCampbell\Credentials\Classes\Credentials  $credentials
     * @return void
     */
    public function __construct(Credentials $credentials)
    {
        $this->setPermissions(array(
            'index' => 'user',
            'show'  => 'user'
        ));

        parent::__construct($credentials);
    }

    /**
     * Display the index page.
     *
     * @param  int  $folder_id
     * @return \Illuminate\Http\Response
     */
    public function index($folder_id)
    {
        return Viewer::make('files.index', array());
    }

    /**
     * Download the specified file.
     *
     * @param  int  $folder_id
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($folder_id, $id)
    {
        $file = FileProvider::find($id);
        $this->checkFile($file);

        return Response::stream($file->getPath());
    }

    /**
     * Check the file model.
     *
     * @param  mixed  $file
     * @return void
     */
    protected function checkFile($file)
    {
        if (!$file) {
            throw new NotFoundHttpException('File Not Found');
        }
    }
}