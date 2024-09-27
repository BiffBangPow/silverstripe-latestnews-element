    <div class="latestnews-title-wrapper py-4 p-xl-5">
        <div class="container">
            <% if $ShowTitle %>
                <h2 class="latestnews-title mb-3 mb-xl-4">$Title</h2>
            <% end_if %>
            $Content
            <% if $CTAType != 'None' %>
                <div class="cta">
                    <p>
                        <a href="$CTALink" class="cta-link"
                            <% if $CTAType == 'External' %>target="_blank" rel="noopener"
                            <% else_if $CTAType == 'Download' %>download
                            <% end_if %>>
                            $LinkText
                        </a>
                    </p>
                </div>
            <% end_if %>
        </div>
    </div>

    <div class="latestnews-stories container">
        <div class="storygrid row row-cols-1 row-cols-sm-2 row-cols-md-3">
            <% loop $LatestPosts %>
                <article class="storyholder mb-4 mb-xl-0 col">
                    <% if $FeaturedImage %>
                        <picture>
                            <% with $FeaturedImage.Fill(600,600) %>
                                <source type="image/webp" srcset="$Format('webp').URL">
                                <img alt="$Up.Title" class="lazyload img-fluid" src="$URL" loading="lazy"
                                     width="$Width" height="$Height">
                            <% end_with %>
                        </picture>
                    <% end_if %>
                    <h3 class="mb-3">$Title</h3>
                    <p class="summary mb-4">$Summary</p>
                    <a href="$Link">
                        <%t LatestNewsElement.ReadMore 'Read More' %>
                    </a>
                </article>
            <% end_loop %>
        </div>
    </div>
