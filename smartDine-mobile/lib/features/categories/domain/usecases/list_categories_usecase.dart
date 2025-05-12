import '../entities/category.dart';
import '../repositories/category_repository.dart';

class ListCategoriesUseCase {
  final CategoryRepository repository;
  ListCategoriesUseCase(this.repository);

  Future<List<Category>> call(int branchId) {
    return repository.fetchCategories(branchId: branchId);
  }
}
