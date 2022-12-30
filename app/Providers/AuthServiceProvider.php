<?php

namespace App\Providers;

use App\Policies\EventPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;

class AuthServiceProvider extends ServiceProvider
{
  /**
   * The policy mappings for the application.
   *
   * @var array
   */
  protected $policies = [
    Event::class => EventPolicy::class,
    User::class => ProfilePolicy::class,
    Answer::class => AnswerPolicy::class,
    Comment::class => CommentPolicy::class,
    Invite::class => InvitePolicy::class,
    Vote::class => VotePolicy::class,
    Account::class => AccountPolicy::class,
    Ban::class => BanPolicy::class,
    Report::class => ReportPolicy::class,
    Poll::class => PollPolicy::class,
    Ban::class => BanPolicy::class,
    Request::class => RequestPolicy::class,
  ];

  /**
   * Register any authentication / authorization services.
   *
   * @return void
   */
  public function boot()
  {
    $this->registerPolicies();
    ResetPassword::createUrlUsing(function ($user, string $token) {
      return 'http://localhost:8001/reset-password/'.$token.'/'.$user->email;
  });
  }
}
