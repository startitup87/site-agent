<div class="wrap">
  <h1>Site Agent Assessment</h1>
  <form id="site-agent-form">
    <div class="form-step" data-step="1">
      <h2>Step 1: Brand Info</h2>
      <input type="text" name="brand" placeholder="Brand Name" required>
      <input type="text" name="industry" placeholder="Industry or Niche">
      <select name="goal">
        <option value="sell">Sell Products</option>
        <option value="book">Book Appointments</option>
        <option value="blog">Blog</option>
        <option value="portfolio">Portfolio</option>
      </select>
      <button type="button" class="next">Next</button>
    </div>
    <div class="form-step" data-step="2">
      <h2>Step 2: Style & Voice</h2>
      <select name="tone">
        <option value="casual">Casual</option>
        <option value="corporate">Corporate</option>
        <option value="gritty">Gritty</option>
        <option value="inspirational">Inspirational</option>
      </select>
      <input type="color" name="primary_color" value="#000000">
      <input type="file" name="logo" accept="image/*">
      <button type="button" class="prev">Back</button>
      <button type="button" class="next">Next</button>
    </div>
    <div class="form-step" data-step="3">
      <h2>Step 3: Features</h2>
      <label><input type="checkbox" name="features[]" value="blog"> Blog</label>
      <label><input type="checkbox" name="features[]" value="store"> Store</label>
      <label><input type="checkbox" name="features[]" value="contact"> Contact</label>
      <label><input type="checkbox" name="features[]" value="booking"> Booking</label>
      <label><input type="checkbox" name="features[]" value="newsletter"> Newsletter</label>
      <button type="button" class="prev">Back</button>
      <button type="button" class="next">Next</button>
    </div>
    <div class="form-step" data-step="4">
      <h2>Step 4: Content Seeds</h2>
      <textarea name="mission" placeholder="What's your mission or offer?"></textarea>
      <input type="text" name="keywords" placeholder="Keywords (comma separated)">
      <input type="text" name="social_links" placeholder="Social links (comma separated)">
      <button type="button" class="prev">Back</button>
      <button type="submit">Generate</button>
    </div>
  </form>
  <div id="site-agent-status"></div>
</div>
