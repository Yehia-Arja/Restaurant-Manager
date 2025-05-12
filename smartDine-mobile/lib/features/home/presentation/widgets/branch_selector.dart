import 'package:flutter/material.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile/core/theme/colors.dart';
import 'package:mobile/features/home/domain/entities/branch.dart';
import 'package:mobile/core/blocs/selected_branch_cubit.dart';

class BranchSelector extends StatefulWidget {
  final List<Branch> branches;
  final VoidCallback? onNotificationTap;

  const BranchSelector({super.key, required this.branches, this.onNotificationTap});

  @override
  State<BranchSelector> createState() => _BranchSelectorState();
}

class _BranchSelectorState extends State<BranchSelector> {
  bool _menuOpen = false;

  @override
  Widget build(BuildContext context) {
    final selectedId = context.watch<SelectedBranchCubit>().state;

    // Safe lookup without generic clashes
    Branch current = widget.branches.first;
    if (selectedId != null) {
      final match = widget.branches.where((b) => b.id == selectedId);
      if (match.isNotEmpty) current = match.first;
    }

    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 6),
      child: Row(
        children: [
          PopupMenuButton<Branch>(
            tooltip: 'Select Branch',
            offset: const Offset(0, 44),
            shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(6)),
            onOpened: () => setState(() => _menuOpen = true),
            onSelected: (b) {
              context.read<SelectedBranchCubit>().select(b.id);
              setState(() => _menuOpen = false);
            },
            onCanceled: () => setState(() => _menuOpen = false),
            itemBuilder:
                (_) =>
                    widget.branches
                        .map((b) => PopupMenuItem(value: b, child: Text(b.locationName)))
                        .toList(),
            child: Row(
              children: [
                const Icon(Icons.location_on_outlined, color: AppColors.primary, size: 14),
                const SizedBox(width: 6),
                Text(
                  current.locationName,
                  style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                    color: AppColors.primary,
                    fontWeight: FontWeight.w600,
                  ),
                ),
                const SizedBox(width: 6),
                Icon(
                  _menuOpen ? CupertinoIcons.chevron_up : CupertinoIcons.chevron_down,
                  color: AppColors.primary,
                  size: 14,
                ),
              ],
            ),
          ),
          const Spacer(),
          IconButton(
            iconSize: 20,
            icon: const Icon(Icons.person, color: AppColors.primary),
            onPressed: widget.onNotificationTap,
          ),
        ],
      ),
    );
  }
}
