import '../entities/table_entity.dart';
import '../repositories/table_repository.dart';

class GetTablesUseCase {
  final TableRepository _repository;

  GetTablesUseCase(this._repository);

  // Fetch all tables for the given branch (restaurant location).
  Future<List<TableEntity>> call(int branchId) {
    return _repository.fetchTables(branchId);
  }
}
