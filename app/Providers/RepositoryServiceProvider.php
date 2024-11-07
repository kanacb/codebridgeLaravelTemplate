<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Interfaces\UserInviteRepositoryInterface;
use App\Repositories\UserInviteRepository;
use App\Interfaces\MailQueRepositoryInterface;
use App\Repositories\MailQueRepository;

// ~cb-import-service-repositories~

// ~cb-import-service-interfaces~

use App\Repositories\CompanyRepository;
use App\Repositories\BranchRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\SectionRepository;
use App\Repositories\RoleRepository;
use App\Repositories\PositionRepository;
use App\Repositories\ProfileRepository;
use App\Repositories\TemplateRepository;
use App\Repositories\MailRepository;
use App\Repositories\TestRepository;
use App\Repositories\PermissionServiceRepository;
use App\Repositories\PermissionFieldRepository;
use App\Repositories\UserAddressRepository;
use App\Repositories\CompanyAddressRepository;
use App\Repositories\CompanyPhoneRepository;
use App\Repositories\UserPhoneRepository;
use App\Repositories\StaffinfoRepository;
use App\Repositories\DynaLoaderRepository;
use App\Repositories\DynaFieldRepository;
use App\Repositories\JobQueRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\SuperiorRepository;
use App\Repositories\CommentRepository;
use App\Repositories\ErrorLogRepository;
use App\Repositories\InboxRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\UserGuideStepRepository;
use App\Repositories\UserGuideRepository;
use App\Repositories\UserLoginRepository;
use App\Repositories\DocumentStorageRepository;
use App\Repositories\DepartmentHODRepository;
use App\Repositories\DepartmentHORepository;


use App\Interfaces\CompanyRepositoryInterface;
use App\Interfaces\BranchRepositoryInterface;
use App\Interfaces\DepartmentRepositoryInterface;
use App\Interfaces\SectionRepositoryInterface;
use App\Interfaces\RoleRepositoryInterface;
use App\Interfaces\PositionRepositoryInterface;
use App\Interfaces\ProfileRepositoryInterface;
use App\Interfaces\TemplateRepositoryInterface;
use App\Interfaces\MailRepositoryInterface;
use App\Interfaces\TestRepositoryInterface;
use App\Interfaces\PermissionServiceRepositoryInterface;
use App\Interfaces\PermissionFieldRepositoryInterface;
use App\Interfaces\UserAddressRepositoryInterface;
use App\Interfaces\CompanyAddressRepositoryInterface;
use App\Interfaces\CompanyPhoneRepositoryInterface;
use App\Interfaces\UserPhoneRepositoryInterface;
use App\Interfaces\StaffinfoRepositoryInterface;
use App\Interfaces\DynaLoaderRepositoryInterface;
use App\Interfaces\DynaFieldRepositoryInterface;
use App\Interfaces\JobQueRepositoryInterface;
use App\Interfaces\EmployeeRepositoryInterface;
use App\Interfaces\SuperiorRepositoryInterface;
use App\Interfaces\CommentRepositoryInterface;
use App\Interfaces\ErrorLogRepositoryInterface;
use App\Interfaces\InboxRepositoryInterface;
use App\Interfaces\NotificationRepositoryInterface;
use App\Interfaces\UserGuideStepRepositoryInterface;
use App\Interfaces\UserGuideRepositoryInterface;
use App\Interfaces\UserLoginRepositoryInterface;
use App\Interfaces\DocumentStorageRepositoryInterface;
use App\Interfaces\DepartmentHODRepositoryInterface;
use App\Interfaces\DepartmentHORepositoryInterface;


class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

        // ~cb-service-provider~

        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserInviteRepositoryInterface::class, UserInviteRepository::class);
        $this->app->bind(MailQueRepositoryInterface::class, MailQueRepository::class);
        $this->app->bind(CompanyRepositoryInterface::class, CompanyRepository::class);
        $this->app->bind(BranchRepositoryInterface::class, BranchRepository::class);
        $this->app->bind(DepartmentRepositoryInterface::class, DepartmentRepository::class);
        $this->app->bind(SectionRepositoryInterface::class, SectionRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(PositionRepositoryInterface::class, PositionRepository::class);
        $this->app->bind(ProfileRepositoryInterface::class, ProfileRepository::class);
        $this->app->bind(TemplateRepositoryInterface::class, TemplateRepository::class);
        $this->app->bind(MailRepositoryInterface::class, MailRepository::class);
        $this->app->bind(TestRepositoryInterface::class, TestRepository::class);
        $this->app->bind(PermissionServiceRepositoryInterface::class, PermissionServiceRepository::class);
        $this->app->bind(PermissionFieldRepositoryInterface::class, PermissionFieldRepository::class);
        $this->app->bind(UserAddressRepositoryInterface::class, UserAddressRepository::class);
        $this->app->bind(CompanyAddressRepositoryInterface::class, CompanyAddressRepository::class);
        $this->app->bind(CompanyPhoneRepositoryInterface::class, CompanyPhoneRepository::class);
        $this->app->bind(UserPhoneRepositoryInterface::class, UserPhoneRepository::class);
        $this->app->bind(StaffinfoRepositoryInterface::class, StaffinfoRepository::class);
        $this->app->bind(DynaLoaderRepositoryInterface::class, DynaLoaderRepository::class);
        $this->app->bind(DynaFieldRepositoryInterface::class, DynaFieldRepository::class);
        $this->app->bind(JobQueRepositoryInterface::class, JobQueRepository::class);
        $this->app->bind(EmployeeRepositoryInterface::class, EmployeeRepository::class);
        $this->app->bind(SuperiorRepositoryInterface::class, SuperiorRepository::class);
        $this->app->bind(CommentRepositoryInterface::class, CommentRepository::class);
        $this->app->bind(ErrorLogRepositoryInterface::class, ErrorLogRepository::class);
        $this->app->bind(InboxRepositoryInterface::class, InboxRepository::class);
        $this->app->bind(NotificationRepositoryInterface::class, NotificationRepository::class);
        $this->app->bind(UserGuideStepRepositoryInterface::class, UserGuideStepRepository::class);
        $this->app->bind(UserGuideRepositoryInterface::class, UserGuideRepository::class);
        $this->app->bind(UserLoginRepositoryInterface::class, UserLoginRepository::class);
        $this->app->bind(DocumentStorageRepositoryInterface::class, DocumentStorageRepository::class);
        $this->app->bind(DepartmentHODRepositoryInterface::class, DepartmentHODRepository::class);
        $this->app->bind(DepartmentHORepositoryInterface::class, DepartmentHORepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
