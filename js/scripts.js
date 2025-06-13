const searchInput = document.getElementById('search-input');
const searchResults = document.getElementById('search-results');

searchInput.addEventListener('input', () => {
  const searchQuery = searchInput.value.toLowerCase();
  const headings = document.querySelectorAll('h1, h2, h3, h4, h5, h6');
  const paragraphs = document.querySelectorAll('p');

  searchResults.innerHTML = '';

  headings.forEach((heading) => {
    const headingText = heading.textContent.toLowerCase();
    if (headingText.includes(searchQuery)) {
      const headingHTML = `<div>${heading.outerHTML}</div>`;
      searchResults.insertAdjacentHTML('beforeend', headingHTML);
    }
  });

  paragraphs.forEach((paragraph) => {
    const paragraphText = paragraph.textContent.toLowerCase();
    if (paragraphText.includes(searchQuery)) {
      const paragraphHTML = `<div>${paragraph.outerHTML}</div>`;
      searchResults.insertAdjacentHTML('beforeend', paragraphHTML);
    }
  });
});


