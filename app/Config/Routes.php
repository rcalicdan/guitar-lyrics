<?php

use App\Controllers\ArtistController;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\Home;
use App\Controllers\Api\ArtistOptionSearchController;
use App\Controllers\Api\CommentsController;
use App\Controllers\Api\SongCategoryOptionSearchController;
use App\Controllers\FeedbackController as ControllersFeedbackController;
use App\Controllers\Homepage\FeedbackController;
use App\Controllers\SongCategoryController;
use App\Controllers\SongController;
use App\Controllers\Homepage\SongController as HomepageSongController;
use App\Controllers\UserProfileController;
use App\Controllers\UsersController;
use App\Controllers\UserSongController;
use App\Controllers\AuditLogController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', [Home::class, 'index'], ['as' => 'home']);
$routes->get('/about-us', [Home::class, 'showAboutUsPage'], ['as' => 'about-us']);

$routes->group('', ['filter' => 'guest'], function (RouteCollection $routes) {
    $routes->get('login', [AuthController::class, 'showLoginPage'], ['as' => 'login']);
    $routes->get('login/comment/(:segment)', [AuthController::class, 'showLoginCommentPage'], ['as' => 'login.comment']);
    $routes->post('login/comment/(:segment)', [AuthController::class, 'loginComment'], ['as' => 'login.comment.post']);
    $routes->post('login', [AuthController::class, 'login'], ['as' => 'login.post']);
    $routes->get('register', [AuthController::class, 'showRegisterPage'], ['as' => 'register']);
    $routes->post('register', [AuthController::class, 'register'], ['as' => 'register.post']);
});

$routes->post('logout', [AuthController::class, 'logout'], ['as' => 'logout.post']);

//Homepage routes
$routes->get('songs', [HomepageSongController::class, 'index'], ['as' => 'home.songs.index']);
$routes->get('songs/(:segment)', [HomepageSongController::class, 'show'], ['as' => 'home.songs.show']);
$routes->get('feedback', [FeedbackController::class, 'index'], ['as' => 'feedback']);
$routes->post('feedback', [FeedbackController::class, 'store'], ['as' => 'feedback.post']);
$routes->get('terms-of-service', fn() => blade_view('contents.homepage.terms'), ['as' => 'terms-of-service']);
$routes->get('privacy-policy', fn() => blade_view('contents.homepage.policies'), ['as' => 'privacy-policy']);


$routes->get('/dashboard', [DashboardController::class, 'index'], ['as' => 'dashboard', 'filter' => 'auth']);

$routes->group('profile', ['filter' => 'auth'], function (RouteCollection $routes) {
    $routes->get('update-personal-information', [UserProfileController::class, 'updateUserInformationPage'], ['as' => 'profile.update-personal-information']);
    $routes->get('update-password', [UserProfileController::class, 'updateUserPasswordPage'], ['as' => 'profile.update-password']);
    $routes->get('update-profile-image', [UserProfileController::class, 'updateUserImagePage'], ['as' => 'profile.update-profile-image']);
    $routes->get('', [UserProfileController::class, 'showUserProfilePage'], ['as' => 'profile.page']);
    $routes->put('update-personal-information', [UserProfileController::class, 'updateUserInformation'], ['as' => 'profile.update-personal-information.post']);
    $routes->put('update-password', [UserProfileController::class, 'updateUserPassword'], ['as' => 'profile.update-password.post']);
    $routes->put('update-profile-image', [UserProfileController::class, 'updateUserImage'], ['as' => 'profile.update-profile-image.post']);
});

$routes->group('users', ['filter' => 'auth'], function (RouteCollection $routes) {
    $routes->get('', [UsersController::class, 'index'], ['as' => 'users.index']);
    $routes->get('create', [UsersController::class, 'create'], ['as' => 'users.create']);
    $routes->post('store', [UsersController::class, 'store'], ['as' => 'users.store']);
    $routes->delete('delete/(:num)', [UsersController::class, 'destroy'], ['as' => 'users.delete']);
    $routes->get('edit/(:num)', [UsersController::class, 'editPage'], ['as' => 'users.edit']);
    $routes->put('update/(:num)', [UsersController::class, 'update'], ['as' => 'users.update']);
});

$routes->group('song', ['filter' => 'auth'], function (RouteCollection $routes) {
    $routes->get('', [SongController::class, 'index'], ['as' => 'songs.index']);
    $routes->get('create', [SongController::class, 'create'], ['as' => 'songs.create']);
    $routes->post('store', [SongController::class, 'store'], ['as' => 'songs.store']);
    $routes->delete('delete/(:segment)', [SongController::class, 'destroy'], ['as' => 'songs.delete']);
    $routes->get('edit/(:segment)', [SongController::class, 'edit'], ['as' => 'songs.edit']);
    $routes->patch('update/(:segment)', [SongController::class, 'update'], ['as' => 'songs.update']);

    $routes->get('categories', [SongCategoryController::class, 'index'], ['as' => 'songs.categories.index']);
    $routes->get('categories/create', [SongCategoryController::class, 'create'], ['as' => 'songs.categories.create']);
    $routes->post('categories/store', [SongCategoryController::class, 'store'], ['as' => 'songs.categories.store']);
    $routes->delete('categories/delete/(:num)', [SongCategoryController::class, 'destroy'], ['as' => 'songs.categories.delete']);
    $routes->get('categories/edit/(:num)', [SongCategoryController::class, 'edit'], ['as' => 'songs.categories.edit']);
    $routes->patch('categories/update/(:num)', [SongCategoryController::class, 'update'], ['as' => 'songs.categories.update']);

    $routes->get('artists', [ArtistController::class, 'index'], ['as' => 'songs.artists.index']);
    $routes->get('artists/(:num)', [ArtistController::class, 'show'], ['as' => 'songs.artists.show']);
    $routes->get('artists/create', [ArtistController::class, 'create'], ['as' => 'songs.artists.create']);
    $routes->post('artists/store', [ArtistController::class, 'store'], ['as' => 'songs.artists.store']);
    $routes->delete('artists/delete/(:num)', [ArtistController::class, 'destroy'], ['as' => 'songs.artists.delete']);
    $routes->get('artists/edit/(:num)', [ArtistController::class, 'edit'], ['as' => 'songs.artists.edit']);
    $routes->patch('artists/update/(:num)', [ArtistController::class, 'update'], ['as' => 'songs.artists.update']);

    $routes->get('view/(:segment)', [SongController::class, 'show'], ['as' => 'songs.show']);
});

$routes->group('my-songs', ['filter' => 'auth'], function (RouteCollection $routes) {
    $routes->get('', [UserSongController::class, 'index'], ['as' => 'my-songs.index']);
    $routes->get('create', [SongController::class, 'create'], ['as' => 'my-songs.create']);
});

$routes->group('user-feedbacks', ['filter' => 'auth'], function (RouteCollection $routes) {
    $routes->get('', [ControllersFeedbackController::class, 'index'], ['as' => 'feedbacks.index']);
    $routes->get('show/(:num)', [ControllersFeedbackController::class, 'show'], ['as' => 'feedbacks.show']);
    $routes->delete('delete/(:num)', [ControllersFeedbackController::class, 'destroy'], ['as' => 'feedbacks.delete']);
});

$routes->group('audit-logs', ['filter' => 'auth'], function (RouteCollection $routes) {
    $routes->get('', [AuditLogController::class, 'index'], ['as' => 'audit-logs.index']);
    $routes->get('show/(:num)', [AuditLogController::class, 'show'], ['as' => 'audit-logs.show']);
});


//Api routes
$routes->group('api/', function (RouteCollection $routes) {
    $routes->get('songs/artists/search', [ArtistOptionSearchController::class, 'search'], ['as' => 'songs.artists.search']);
    $routes->get('songs/categories/search', [SongCategoryOptionSearchController::class, 'search'], ['as' => 'songs.categories.search']);
    $routes->get('songs/(:segment)/comments', [CommentsController::class, 'index'], ['as' => 'api.songs.comments.index']);
    $routes->get('songs/(:segment)/comments/load-more', [CommentsController::class, 'loadMore'], ['as' => 'api.songs.comments.load-more']);
    $routes->post('songs/(:segment)/increment-view', [HomepageSongController::class, 'incrementView'], ['as' => 'api.songs.increment-view']);
});

$routes->group('api/songs/(:segment)', ['filter' => 'auth'], function (RouteCollection $routes) {
    $routes->post('comments', [CommentsController::class, 'store'], ['as' => 'api.songs.comments.store']);
    $routes->patch('comments/(:num)', [CommentsController::class, 'update'], ['as' => 'api.songs.comments.update']);
    $routes->delete('comments/(:num)', [CommentsController::class, 'delete'], ['as' => 'api.songs.comments.delete']);
});
