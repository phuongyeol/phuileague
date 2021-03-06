<div class="header-tournament">
    <div class="container">
        <!-- Header TabList -->
        <div id="tablist-header" class="tablist">
            <ul class="nav nav-tabs">
                <li role="presentation" class="active"><a href="{{ route('tournament.setting', $tournament->slug)}}">Tùy chỉnh</a></li>
                <li role="presentation"><a href="{{ route('tournament.dashboard', $tournament->slug)}}">Tin chung</a></li>
                <li role="presentation"><a href="{{ route('tournament.listregister', $tournament->slug)}}">Danh sách đăng ký</a></li>
                <li role="presentation"><a href="{{ route('tournament.stagegroup', $tournament->slug)}}">Vòng bảng</a></li>
                <li role="presentation"><a href="{{ route('tournament.knockout', $tournament->slug)}}">Vòng loại trực tiếp</a></li>
                <li role="presentation"><a href="{{ route('tournament.ranking', $tournament->slug)}}">Bảng xếp hạng</a></li>
                <li role="presentation"><a href="{{ route('tournament.listclub', $tournament->slug)}}">Đội bóng</a></li>
                <li role="presentation"><a href="{{ route('tournament.statistics', $tournament->slug)}}">Thống kê</a></li>
                <li role="presentation"><a href="{{ route('tournament.about', $tournament->slug)}}">Giới thiệu và điều lệ</a></li>
            </ul>
        </div>
    </div>
</div>