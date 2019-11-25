<!--begin: Head -->
<div class="kt-user-card kt-user-card--skin-light kt-notification-item-padding-x">
    <div class="kt-user-card__avatar">
        <img class="kt-hidden-" alt="Pic" src="{{ URL::asset('assets/media/users/300_25.jpg') }}" />
        <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
        <span class="kt-badge kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bold kt-hidden">S</span>
    </div>
    <div class="kt-user-card__name"> Sean Stone </div>
    <div class="kt-user-card__badge"> <span class="btn btn-label-primary btn-sm btn-bold btn-font-md">23 messages</span> </div>
</div>
<!--end: Head -->
<!--begin: Navigation -->
<div class="kt-notification">
    <a href="#" class="kt-notification__item">
        <div class="kt-notification__item-icon"> <i class="flaticon2-calendar-3 kt-font-success"></i> </div>
        <div class="kt-notification__item-details">
            <div class="kt-notification__item-title kt-font-bold"> My Profile </div>
            <div class="kt-notification__item-time"> Account settings and more </div>
        </div>
    </a>
    <a href="#" class="kt-notification__item">
        <div class="kt-notification__item-icon"> <i class="flaticon2-mail kt-font-warning"></i> </div>
        <div class="kt-notification__item-details">
            <div class="kt-notification__item-title kt-font-bold"> My Messages </div>
            <div class="kt-notification__item-time"> Inbox and tasks </div>
        </div>
    </a>
    <a href="#" class="kt-notification__item">
        <div class="kt-notification__item-icon"> <i class="flaticon2-rocket-1 kt-font-danger"></i> </div>
        <div class="kt-notification__item-details">
            <div class="kt-notification__item-title kt-font-bold"> My Activities </div>
            <div class="kt-notification__item-time"> Logs and notifications </div>
        </div>
    </a>
    <a href="#" class="kt-notification__item">
        <div class="kt-notification__item-icon"> <i class="flaticon2-hourglass kt-font-brand"></i> </div>
        <div class="kt-notification__item-details">
            <div class="kt-notification__item-title kt-font-bold"> My Tasks </div>
            <div class="kt-notification__item-time"> latest tasks and projects </div>
        </div>
    </a>
    <a href="#" class="kt-notification__item">
        <div class="kt-notification__item-icon"> <i class="flaticon2-cardiogram kt-font-warning"></i> </div>
        <div class="kt-notification__item-details">
            <div class="kt-notification__item-title kt-font-bold"> Billing </div>
            <div class="kt-notification__item-time"> billing & statements <span class="kt-badge kt-badge--danger kt-badge--inline kt-badge--pill kt-badge--rounded">2 pending</span> </div>
        </div>
    </a>
    <div class="kt-notification__custom kt-space-between">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" href="#" target="#" class="btn btn-label btn-label-brand btn-sm btn-bold">Sign Out</button>
            <a href="#" target="_blank" class="btn btn-clean btn-sm btn-bold">Upgrade Plan</a>
        </form>
    </div>
</div>
<!--end: Navigation -->
