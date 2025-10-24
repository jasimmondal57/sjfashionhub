import 'package:flutter/material.dart';
import 'package:carousel_slider/carousel_slider.dart';
import 'package:smooth_page_indicator/smooth_page_indicator.dart';
import '../config/app_theme.dart';
import '../config/app_config.dart';
import '../models/product.dart';
import '../models/category.dart';
import '../models/banner.dart' as app_banner;
import '../widgets/product_card.dart';
import '../services/api_service.dart';

/// Home screen with search, categories, banners, and products
class HomeScreen extends StatefulWidget {
  const HomeScreen({super.key});

  @override
  State<HomeScreen> createState() => _HomeScreenState();
}

class _HomeScreenState extends State<HomeScreen> {
  final ApiService _apiService = ApiService();
  final CarouselSliderController _carouselController =
      CarouselSliderController();

  int _currentBannerIndex = 0;
  int _selectedBottomNavIndex = 0;

  List<Category> _categories = [];
  List<app_banner.Banner> _banners = [];
  List<Product> _products = [];

  bool _isLoading = true;
  String? _error;

  @override
  void initState() {
    super.initState();
    _loadData();
  }

  Future<void> _loadData() async {
    setState(() {
      _isLoading = true;
      _error = null;
    });

    try {
      // Load categories, banners, and products in parallel
      final results = await Future.wait([
        _apiService.getCategories(),
        _apiService.getBanners(),
        _apiService.getProducts(page: 1, perPage: 20),
      ]);

      setState(() {
        // Parse categories (handle empty array)
        final categoriesData = results[0] as List;
        _categories = categoriesData.isNotEmpty
            ? categoriesData.map((json) => Category.fromJson(json)).toList()
            : [];

        // Parse banners (handle empty array)
        final bannersData = results[1] as List;
        _banners = bannersData.isNotEmpty
            ? bannersData
                  .map((json) => app_banner.Banner.fromJson(json))
                  .toList()
            : [];

        // Parse products
        final productsResponse = results[2] as Map<String, dynamic>;
        final productsData = productsResponse['data'] as List;
        _products = productsData.isNotEmpty
            ? productsData.map((json) => Product.fromJson(json)).toList()
            : [];

        _isLoading = false;
      });
    } catch (e, stackTrace) {
      setState(() {
        _error = 'Failed to load data: $e';
        _isLoading = false;
      });
      print('Error loading data: $e');
      print('Stack trace: $stackTrace');
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppTheme.backgroundLight,
      body: SafeArea(
        child: _isLoading
            ? const Center(child: CircularProgressIndicator())
            : _error != null
            ? Center(
                child: Column(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    Text(_error!),
                    const SizedBox(height: 16),
                    ElevatedButton(
                      onPressed: _loadData,
                      child: const Text('Retry'),
                    ),
                  ],
                ),
              )
            : RefreshIndicator(
                onRefresh: _loadData,
                child: CustomScrollView(
                  slivers: [
                    // Header
                    SliverToBoxAdapter(child: _buildHeader()),

                    // Search Bar
                    SliverToBoxAdapter(child: _buildSearchBar()),

                    // Categories
                    SliverToBoxAdapter(child: _buildCategories()),

                    // Banners
                    if (_banners.isNotEmpty)
                      SliverToBoxAdapter(child: _buildBanners()),

                    // Section Title
                    SliverToBoxAdapter(
                      child: Padding(
                        padding: const EdgeInsets.all(16),
                        child: Row(
                          mainAxisAlignment: MainAxisAlignment.spaceBetween,
                          children: [
                            Text(
                              'Featured Products',
                              style: Theme.of(context).textTheme.headlineMedium,
                            ),
                            TextButton(
                              onPressed: () {
                                // Navigate to all products
                              },
                              child: const Text('See All'),
                            ),
                          ],
                        ),
                      ),
                    ),

                    // Products Grid
                    SliverPadding(
                      padding: const EdgeInsets.symmetric(horizontal: 16),
                      sliver: SliverGrid(
                        gridDelegate:
                            const SliverGridDelegateWithFixedCrossAxisCount(
                              crossAxisCount: 2,
                              childAspectRatio: 0.65,
                              crossAxisSpacing: 12,
                              mainAxisSpacing: 12,
                            ),
                        delegate: SliverChildBuilderDelegate((context, index) {
                          return ProductCard(
                            product: _products[index],
                            onTap: () {
                              // Navigate to product detail
                              Navigator.pushNamed(
                                context,
                                '/product',
                                arguments: _products[index],
                              );
                            },
                            onFavorite: () {
                              // Add to wishlist
                            },
                          );
                        }, childCount: _products.length),
                      ),
                    ),

                    // Bottom Padding
                    const SliverToBoxAdapter(child: SizedBox(height: 16)),
                  ],
                ),
              ),
      ),
      bottomNavigationBar: _buildBottomNavigationBar(),
    );
  }

  Widget _buildHeader() {
    return Container(
      padding: const EdgeInsets.all(16),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Text(
            'SJ Fashion Hub',
            style: Theme.of(
              context,
            ).textTheme.headlineMedium?.copyWith(fontWeight: FontWeight.w800),
          ),
          IconButton(
            icon: const Icon(Icons.shopping_bag_outlined),
            onPressed: () {
              Navigator.pushNamed(context, '/cart');
            },
          ),
        ],
      ),
    );
  }

  Widget _buildSearchBar() {
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 16),
      child: GestureDetector(
        onTap: () {
          Navigator.pushNamed(context, '/search');
        },
        child: Container(
          padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 14),
          decoration: BoxDecoration(
            color: AppTheme.inputBackground,
            borderRadius: BorderRadius.circular(9999),
          ),
          child: Row(
            children: [
              Icon(Icons.search, color: AppTheme.textSecondary, size: 20),
              const SizedBox(width: 12),
              Text(
                'Search for items or brands',
                style: TextStyle(color: AppTheme.textSecondary, fontSize: 14),
              ),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildCategories() {
    if (_categories.isEmpty) return const SizedBox.shrink();

    return Container(
      height: 120,
      margin: const EdgeInsets.symmetric(vertical: 16),
      child: ListView.builder(
        scrollDirection: Axis.horizontal,
        padding: const EdgeInsets.symmetric(horizontal: 16),
        itemCount: _categories.length,
        itemBuilder: (context, index) {
          final category = _categories[index];
          return GestureDetector(
            onTap: () {
              // Navigate to category products
              Navigator.pushNamed(context, '/category', arguments: category);
            },
            child: Container(
              width: 80,
              margin: const EdgeInsets.only(right: 16),
              child: Column(
                children: [
                  Container(
                    width: 80,
                    height: 80,
                    decoration: BoxDecoration(
                      color: AppTheme.inputBackground,
                      shape: BoxShape.circle,
                      border: Border.all(color: AppTheme.borderLight, width: 1),
                    ),
                    child: category.imageUrl != null
                        ? ClipOval(
                            child: Image.network(
                              '${AppConfig.storageUrl}/${category.imageUrl}',
                              fit: BoxFit.cover,
                              errorBuilder: (context, error, stackTrace) {
                                return const Icon(
                                  Icons.category,
                                  size: 32,
                                  color: AppTheme.textSecondary,
                                );
                              },
                            ),
                          )
                        : const Icon(
                            Icons.category,
                            size: 32,
                            color: AppTheme.textSecondary,
                          ),
                  ),
                  const SizedBox(height: 8),
                  Text(
                    category.name,
                    style: const TextStyle(
                      fontSize: 12,
                      fontWeight: FontWeight.w500,
                    ),
                    textAlign: TextAlign.center,
                    maxLines: 1,
                    overflow: TextOverflow.ellipsis,
                  ),
                ],
              ),
            ),
          );
        },
      ),
    );
  }

  Widget _buildBanners() {
    return Column(
      children: [
        CarouselSlider.builder(
          carouselController: _carouselController,
          itemCount: _banners.length,
          itemBuilder: (context, index, realIndex) {
            final banner = _banners[index];
            return Container(
              margin: const EdgeInsets.symmetric(horizontal: 8),
              decoration: BoxDecoration(
                borderRadius: BorderRadius.circular(16),
                boxShadow: [
                  BoxShadow(
                    color: Colors.black.withOpacity(0.1),
                    blurRadius: 8,
                    offset: const Offset(0, 4),
                  ),
                ],
              ),
              child: ClipRRect(
                borderRadius: BorderRadius.circular(16),
                child: Image.network(
                  '${AppConfig.storageUrl}/${banner.imageUrl}',
                  fit: BoxFit.cover,
                  width: double.infinity,
                  errorBuilder: (context, error, stackTrace) {
                    return Container(
                      color: AppTheme.inputBackground,
                      child: const Center(
                        child: Icon(
                          Icons.image_not_supported,
                          size: 48,
                          color: AppTheme.textSecondary,
                        ),
                      ),
                    );
                  },
                ),
              ),
            );
          },
          options: CarouselOptions(
            height: 180,
            viewportFraction: 0.9,
            autoPlay: true,
            autoPlayInterval: const Duration(seconds: 5),
            enlargeCenterPage: true,
            onPageChanged: (index, reason) {
              setState(() {
                _currentBannerIndex = index;
              });
            },
          ),
        ),
        const SizedBox(height: 16),
        AnimatedSmoothIndicator(
          activeIndex: _currentBannerIndex,
          count: _banners.length,
          effect: const WormEffect(
            dotHeight: 8,
            dotWidth: 8,
            activeDotColor: AppTheme.primaryColor,
            dotColor: AppTheme.borderLight,
          ),
        ),
      ],
    );
  }

  Widget _buildBottomNavigationBar() {
    return BottomNavigationBar(
      currentIndex: _selectedBottomNavIndex,
      onTap: (index) {
        setState(() {
          _selectedBottomNavIndex = index;
        });

        // Navigate based on index
        switch (index) {
          case 0:
            // Home - already here
            break;
          case 1:
            Navigator.pushNamed(context, '/categories');
            break;
          case 2:
            Navigator.pushNamed(context, '/wishlist');
            break;
          case 3:
            Navigator.pushNamed(context, '/profile');
            break;
        }
      },
      items: const [
        BottomNavigationBarItem(
          icon: Icon(Icons.home_outlined),
          activeIcon: Icon(Icons.home),
          label: 'Home',
        ),
        BottomNavigationBarItem(
          icon: Icon(Icons.category_outlined),
          activeIcon: Icon(Icons.category),
          label: 'Categories',
        ),
        BottomNavigationBarItem(
          icon: Icon(Icons.favorite_border),
          activeIcon: Icon(Icons.favorite),
          label: 'Wishlist',
        ),
        BottomNavigationBarItem(
          icon: Icon(Icons.person_outline),
          activeIcon: Icon(Icons.person),
          label: 'Profile',
        ),
      ],
    );
  }
}
