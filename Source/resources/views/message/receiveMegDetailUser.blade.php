<!-- Message. Default to the left -->
                <div class="direct-chat-msg">
                  <img class="direct-chat-img" src="{{$getUserInfo->thumbnail_url}}" alt="{{$getUserInfo->nick_name}}"><!-- /.direct-chat-img -->
                  @if ($row->message != '')
                  <div class="direct-chat-text">
                    {!! nl2br(e($row->message)) !!}
                  </div><!-- /.direct-chat-text -->

                  @else
                  <div class="direct-chat-text">
                    <a href=" {{$row->img_url }}/0/0"  target="_blank" ><img src=" {{$row->img_url }}/160/160" ></a>
                  </div>
                  @endif
                  <div class="direct-chat-info clearfix">
                    <span class="direct-chat-timestamp pull-right">{{date(Lang::get('website.date_format'), strtotime($row->created_at))}}</span>
                  </div><!-- /.direct-chat-info -->
                </div><!-- /.direct-chat-msg -->
