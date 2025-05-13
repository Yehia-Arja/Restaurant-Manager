import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile/core/blocs/selected_restaurant_cubit.dart';
import 'package:mobile/features/orders/presentation/bloc/order_bloc.dart';
import 'package:mobile/features/orders/presentation/bloc/order_event.dart';
import 'package:mobile/features/orders/presentation/bloc/order_state.dart';
import 'package:mobile/features/tables/domain/usecases/get_tables_usecase.dart';

// A button that handles fetching tables, showing a picker dialog,
// and dispatching a place-order event.
class ConfirmOrderButton extends StatelessWidget {
  final int productId;

  const ConfirmOrderButton({super.key, required this.productId});

  @override
  Widget build(BuildContext context) {
    return BlocConsumer<OrderBloc, OrderState>(
      listener: (context, state) {
        if (state is OrderSuccess) {
          ScaffoldMessenger.of(
            context,
          ).showSnackBar(const SnackBar(content: Text('Order placed successfully!')));
        } else if (state is OrderFailure) {
          ScaffoldMessenger.of(context).showSnackBar(SnackBar(content: Text(state.message)));
        }
      },
      builder: (context, state) {
        return SizedBox(
          width: double.infinity,
          height: 48,
          child: ElevatedButton(
            onPressed:
                state is OrderInProgress
                    ? null
                    : () async {
                      // get selected restaurant (branch) id
                      final branchId = context.read<SelectedRestaurantCubit>().state;
                      if (branchId == null) return;

                      // fetch tables for this branch
                      final tables = await context.read<GetTablesUseCase>()(branchId);
                      int? selectedTable;

                      // show table selector dialog
                      final tableNumber = await showDialog<int>(
                        context: context,
                        builder: (ctx) {
                          final freeTables = tables.where((t) => !t.isOccupied).toList();
                          return AlertDialog(
                            title: const Text('Which table are you on?'),
                            content: StatefulBuilder(
                              builder: (context, setState) {
                                return DropdownButton<int>(
                                  isExpanded: true,
                                  value: selectedTable,
                                  hint: const Text('Select table'),
                                  items:
                                      freeTables.map((t) {
                                        return DropdownMenuItem(
                                          value: t.id,
                                          child: Text('Table ${t.id} (Floor ${t.floor})'),
                                        );
                                      }).toList(),
                                  onChanged: (val) => setState(() => selectedTable = val),
                                );
                              },
                            ),
                            actions: [
                              TextButton(
                                onPressed: () => Navigator.of(ctx).pop(),
                                child: const Text('Cancel'),
                              ),
                              TextButton(
                                onPressed:
                                    selectedTable == null
                                        ? null
                                        : () => Navigator.of(ctx).pop(selectedTable),
                                child: const Text('Confirm'),
                              ),
                            ],
                          );
                        },
                      );

                      // dispatch order event
                      if (tableNumber != null) {
                        context.read<OrderBloc>().add(
                          PlaceOrderRequested(
                            productId: productId,
                            branchId: branchId,
                            tableNumber: tableNumber,
                          ),
                        );
                      }
                    },
            child:
                state is OrderInProgress
                    ? const SizedBox(
                      width: 24,
                      height: 24,
                      child: CircularProgressIndicator(color: Colors.white, strokeWidth: 2),
                    )
                    : const Text('Confirm Order'),
          ),
        );
      },
    );
  }
}
