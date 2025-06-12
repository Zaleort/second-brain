package com.zaleort.second_brain.Memories.Infrastructure.Controllers

import com.zaleort.second_brain.Memories.Application.UseCases.GetMemories.GetMemoriesCommand
import com.zaleort.second_brain.Memories.Application.UseCases.GetMemories.GetMemoriesHandler
import com.zaleort.second_brain.Memories.Application.UseCases.MemoryDTO
import com.zaleort.second_brain.Shared.Domain.QueryFilter.PaginatedResult
import org.springframework.http.HttpStatus
import org.springframework.http.ResponseEntity
import org.springframework.security.core.annotation.AuthenticationPrincipal
import org.springframework.security.core.userdetails.UserDetails
import org.springframework.web.bind.annotation.GetMapping
import org.springframework.web.bind.annotation.RequestParam
import org.springframework.web.bind.annotation.RestController

@RestController
class GetMemoriesController(
    private val handler: GetMemoriesHandler,
) {
    @GetMapping("/api/v1/memories")
    fun getMemories(
        @AuthenticationPrincipal user: UserDetails,
        @RequestParam(required = false) page: Int?,
        @RequestParam(required = false) limit: Int?,
        @RequestParam(required = false) orderBy: String?,
        @RequestParam(required = false) orderDirection: String?,
        @RequestParam(required = false) title: String?,
        @RequestParam(required = false) tags: List<String>?,
        @RequestParam(required = false) content: String?,
        @RequestParam(required = false) type: Int?,
        @RequestParam(required = false) createdAtFrom: String?,
        @RequestParam(required = false) createdAtTo: String?,
    ): ResponseEntity<PaginatedResult<MemoryDTO>> {

        val userId = user.username
        val memories = handler.execute(GetMemoriesCommand(
            page = page ?: 0,
            limit = limit ?: 12,
            orderBy = orderBy ?: "createdAt",
            orderDirection = orderDirection ?: "DESC",
            userId = userId,
            title,
            content,
            tags = tags ?: emptyList(),
            type,
            createdAtFrom,
            createdAtTo
        ))
        return ResponseEntity(memories, HttpStatus.OK)
    }
}