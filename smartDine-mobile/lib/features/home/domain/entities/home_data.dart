import 'package:mobile/features/home/domain/entities/branch.dart';
import 'package:mobile/features/categories/domain/entities/category.dart';
import 'package:mobile/features/products/domain/entities/product.dart';

class HomeData {
  final List<Branch> branches;
  final Branch selectedBranch;
  final List<Category> categories;
  final List<Product> products;

  const HomeData({
    required this.branches,
    required this.selectedBranch,
    required this.categories,
    required this.products,
  });

  HomeData copyWith({
    List<Branch>? branches,
    Branch? selectedBranch,
    List<Category>? categories,
    List<Product>? products,
  }) {
    return HomeData(
      branches: branches ?? this.branches,
      selectedBranch: selectedBranch ?? this.selectedBranch,
      categories: categories ?? this.categories,
      products: products ?? this.products,
    );
  }

  @override
  bool operator ==(Object other) =>
      identical(this, other) ||
      other is HomeData &&
          runtimeType == other.runtimeType &&
          branches == other.branches &&
          selectedBranch == other.selectedBranch &&
          categories == other.categories &&
          products == other.products;

  @override
  int get hashCode =>
      branches.hashCode ^ selectedBranch.hashCode ^ categories.hashCode ^ products.hashCode;
}
