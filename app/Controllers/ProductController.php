<?php

class ProductController extends Controller
{
    public $product;

    public function __construct()
    {
        $db = new Database();
        $product = new Product($db);
    }

    public function index()
    {
        $products = $this->product->getAll();
        $this->view('home', $products);
    }

    public function show($id)
    {
        $product = $this->product->getByCategory();
        $this->view('home', $product);
    }
}
