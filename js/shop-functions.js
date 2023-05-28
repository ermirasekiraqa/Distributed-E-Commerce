// Create products cards
function outputProduct(item) {
  let productDiv = document.createElement("div");
  productDiv.className = "product";
  productDiv.dataset.productId = item.id;
  productDiv.appendChild(createProductImg(item));
  productDiv.appendChild(createProductDescription(item));
  return productDiv;
}

function createProductImg(item) {
  let productAnchor = document.createElement("a");
  productAnchor.href = `product.php?id=${item.id}`;
  let productImg = document.createElement("img");
  productImg.src = "images".concat("/", item.image)
  productAnchor.appendChild(productImg);
  return productAnchor;
}

function createProductDescription(item) {
  let productDescription = document.createElement("div");
  productDescription.className = "product-description";
  productDescription.appendChild(createProductBrand(item));
  productDescription.appendChild(createProductName(item));
  productDescription.appendChild(createProductPrice(item));
  productDescription.appendChild(createShoppingCartIcon(item));
  return productDescription;
}

function createProductBrand(item) {
  let brand = document.createElement("span");
  brand.innerText = item.brand;
  return brand;
}

function createProductName(item) {
  let productName = document.createElement("h5");
  productName.innerText = item.productname;
  return productName;
}

function createProductPrice(item) {
  let productPrice = document.createElement("h4");
  productPrice.innerText = "$" + item.price;
  return productPrice;
}

function createShoppingCartIcon(item) {
  let cartAnchor = document.createElement("a");
  cartAnchor.href = `product.php?id=${item.id}`;
  let cartIcon = document.createElement("i");
  cartIcon.className = "fa fa-shopping-cart cart";
  cartAnchor.appendChild(cartIcon);
  return cartAnchor;
}

// Display products
function displayProducts(products) {
  productSection.innerHTML = "";
  for (let i = (currentPage - 1) * (rows * 3); i < currentPage * rows * 3 && i < products.length; i++) {
    productSection.appendChild(outputProduct(products[i]));
  }
}

let productSection = document.getElementById("product-container");
let rows = 3;
let currentPage = 1;  // Current page 

// Display pagination buttons
function displayPaginationButtons(pageCount) {
  let paginationSection = document.getElementsByClassName("pages").item(0);
  if (pageCount > 1) {
    let prevButton = document.createElement("button");
    prevButton.onclick = prevPage;
    let leftArrowIcon = document.createElement("i");
    leftArrowIcon.className = "fa fa-long-arrow-left";
    prevButton.appendChild(leftArrowIcon);
    paginationSection.appendChild(prevButton);
  }

  for (let i = 0; i < pageCount; i++) {
    let numButton = document.createElement("button");
    numButton.onclick = loadPage;
    numButton.innerText = i + 1;
    paginationSection.appendChild(numButton);
  }

  if (pageCount > 1) {
    let nextButton = document.createElement("button");
    nextButton.onclick = nextPage;
    let rightArrowIcon = document.createElement("i");
    rightArrowIcon.className = "fa fa-long-arrow-right";
    nextButton.appendChild(rightArrowIcon);
    paginationSection.appendChild(nextButton);
  }
}

function nextPage() {
  if (currentPage === pageSize) return;
  currentPage += 1;
  fetchProducts();
}

function prevPage() {
  if (currentPage === 1) return;
  currentPage -= 1;
  fetchProducts();
}

function loadPage(clickEvent) {
  let pageNumber = parseInt(clickEvent.target.innerText);
  currentPage = pageNumber;
  fetchProducts();
}

// Fetch product data from PHP using AJAX
function fetchProducts() {
  // Make an AJAX request to products.php
  fetch("products.php")
    .then((response) => response.json())
    .then((data) => {
      displayProducts(data);
    })
    .catch((error) => {
      console.error("Error fetching product data:", error);
    });
}

function getPageCountAndDisplayPaginationButtons() {
  // Make an AJAX request to products.php
  fetch("products.php")
    .then((response) => response.json())
    .then((data) => {
      // Pagination
      pageSize = Math.ceil(data.length / (rows * 3));
      displayPaginationButtons(pageSize);
    })
    .catch((error) => {
      console.error("Error fetching product data:", error);
    });
}

// Load initial page
fetchProducts();
getPageCountAndDisplayPaginationButtons();