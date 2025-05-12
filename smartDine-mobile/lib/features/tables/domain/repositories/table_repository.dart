import '../entities/table_entity.dart';

abstract class TableRepository {
  Future<List<TableEntity>> fetchTables(int restaurantLocationId);
}
