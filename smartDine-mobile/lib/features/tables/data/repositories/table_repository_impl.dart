import '../../domain/entities/table_entity.dart';
import '../../domain/repositories/table_repository.dart';
import '../datasource/tables_remote.dart';

class TableRepositoryImpl implements TableRepository {
  final TablesRemote _remote;
  TableRepositoryImpl(this._remote);

  @override
  Future<List<TableEntity>> fetchTables(int branchId) {
    return _remote.fetchTables(branchId);
  }
}
