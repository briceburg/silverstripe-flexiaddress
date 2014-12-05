<div class="address">
<address itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">

  <% if StreetLine1 %>
    <span itemprop="streetAddress" class="streetAddress">$StreetLine1</span>
  <% end_if %>
  
  <% if StreetLine2 %>
    <span itemprop="streetAddress" class="streetAddress">$StreetLine2</span>
  <% end_if %>
  
  <% if City %>
     <span itemprop="addressLocality" class="addressLocality">$City</span>
  <% end_if %>
  
  <% if State %>
     <span itemprop="addressRegion" class="addressRegion">$FullStateName</span>
  <% end_if %>
  
  <% if PostalCode %>
    <span itemprop="postalCode" class="postalCode">$PostalCode</span>
  <% end_if %>

</address>
</div>
