import '../../domain/entities/category.dart';
import '../../domain/repositories/category_repository.dart';
import '../datasources/category_remote.dart';

class CategoryRepositoryImpl implements CategoryRepository {
  final CategoryRemote _remote;
  CategoryRepositoryImpl(this._remote);

  @override
  Future<List<Category>> fetchCategories({required int branchId}) {
    return _remote.fetchCategories(branchId);
  }
}
