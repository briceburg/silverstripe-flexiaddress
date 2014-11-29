<div class="contact-point" itemprop="ContactPoint" itemscope itemtype="http://schema.org/ContactPoint">
  <meta itemprop="contactType" content="$MetaType.ATT" />
  <% if MetaTollFree %><meta itemprop="contactOption" content="TollFree" /><% end_if %>
  
  <a href="tel:{$IntlTelephone}" itemprop="<% if MetaFax %>faxNumber<% else %>telephone<% end_if %>" class="telephone">$Telephone</a> 
  <% if Label %>($Label)<% end_if %>
</div>
