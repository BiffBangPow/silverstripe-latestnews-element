    <div class="latestnews-title-wrapper py-4 p-xl-5">
        <div  class="container">
            <% if $ShowTitle %>
                <h2 class="latestnews-title mb-3 mb-xl-4">$Title</h2>
            <% end_if %>
            $Content
            <% if $NewsLink %>
                <a class="bubble-btn-grey-1 mt-3 mt-xl-4" href="$NewsLink.Link"><%t LatestNewsElement.AllNews 'All News' %></a>
            <% end_if %>
        </div>
    </div>

    <div class="latestnews-image d-none d-xl-block bg-cover"
         style="background-image: url('<% if $WebPSupport %>$Image.ScaleMaxWidth(1000).Format('webp').URL<% else %>$Image.ScaleMaxWidth(1000).URL<% end_if %>')"
    ></div>
    <div class="latestnews-stories brand-bg-gradient pt-xl-6">
        <div class="storygrid container ms-xl-0 py-4 pt-xl-0">
            <% loop $LatestPosts %>
                <article class="storyholder mb-4 mb-xl-0">
                    <h3 class="mb-3">$Title</h3>
                    <p class="summary mb-4">$Summary</p>
                    <a href="$Link">
                        <%t LatestNewsElement.ReadMore 'Read More' %>
                    </a>
                </article>
            <% end_loop %>
        </div>
    </div>