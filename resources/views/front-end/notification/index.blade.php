@extends('layouts.fe')
@section('content')
    @can('member_create')
    @endcan
    <div class="card">
        <div class="card-header">
            Thông báo chính thức
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered">
                    <thead>
                        <tr>
                            <th>
                                {{ trans('cruds.news.fields.id') }}
                            </th>
                            <th>
                                Subject
                            </th>
                            <th>
                                Published_date
                            </th>
                            <th>
                                Published To
                            </th>
                            <th>
                                Attachment
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($notification as $key => $item)
                            <tr data-entry-id="{{ $item->id }}">
                                <td>
                                    {{ $item->notificationId ?? '' }}
                                </td>
                                <td>
                                    {{ $item->subject ?? '' }}
                                </td>
                                <td>
                                    {{ $item['published_date'] ?? '' }}
                                </td>
                                <td>
                                    @if ($item->published_to == null)
                                        <p>All</p>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ asset('/storage/uploads/' . $item->attachment) }}"
                                        target="_blank">{{ $item['attachment'] ?? '' }}</a>
                                </td>
                                <td>
                                    @can('member_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('user.notification.show', $item->id) }}">
                                            view
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection
