               <!-- Message to the right -->
                <div class="direct-chat-msg right">
                  <img class="direct-chat-img" src="/dist/img/icon_user.png" alt="Message User Image"><!-- /.direct-chat-img -->

                  @if ($row->message != '')
                  <div class="direct-chat-text">
                    {!! nl2br(e($row->message)) !!}
                  </div><!-- /.direct-chat-text -->

                  @else
                  <div class="direct-chat-text">
                    <a href=" {{$row->img_url }}"  target="_blank" ><img src=" {{$row->img_url }}" width="160" height="160"></a>
                  </div>
                  @endif
                  <div class="direct-chat-info clearfix">
                    <span class="direct-chat-timestamp pull-left">{{date(Lang::get('website.date_format'), strtotime($row->created_at))}}</span>
                  </div><!-- /.direct-chat-info -->
                </div><!-- /.direct-chat-msg -->
